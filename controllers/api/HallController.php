<?php

namespace app\controllers\api;

use app\models\Halls;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use app\components\HttpBearerAuth;
use app\models\Categories;
use yii\web\BadRequestHttpException;
use Yii;

class HallController extends ActiveController
{
    public $modelClass = 'app\models\Halls';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'optional' => ['index', 'view'],
        ];

        return $behaviors;
    }

    /**
     * Просмотр свободных слотов для зала
     * URL: GET /api/halls/{id}/available-slots?date=2025-01-10
     */
    public function actionAvailableSlots($id)
    {
        $date = Yii::$app->request->get('date');
        
        if (empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Date is required and must be in YYYY-MM-DD format'
                ]
            ];
        }

        $hall = Halls::findOne($id);
        if ($hall === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Hall not found'
            ];
        }

        $bookedSlots = \app\models\Bookings::find()
            ->select('time_slot')
            ->where([
                'hall_id' => $id,
                'date' => $date,
            ])
            ->andWhere(['!=', 'status', \app\models\Bookings::STATUS_CANCELLED])
            ->column();

        $allSlots = [];
        for ($hour = 9; $hour <= 22; $hour++) {
            $slot = sprintf('%02d:00', $hour);
            if (!in_array($slot, $bookedSlots)) {
                $allSlots[] = $slot;
            }
        }

        return [
            'hall_id' => $id,
            'date' => $date,
            'available_slots' => $allSlots
        ];
    }

    /**
     * Проверка прав администратора
     */
    private function checkAdmin()
    {
        $user = Yii::$app->user->identity;
        if ($user === null || !$user->isRoleAdmin()) {
            throw new ForbiddenHttpException('Forbidden. Admin access required');
        }
    }

    /**
     * Форматирование зала для ответа
     */
    private function formatHall($hall)
    {
        $host = Yii::$app->request->hostInfo;
        $category = $hall->category;
        
        return [
            'id' => $hall->id_hall,
            'title' => $hall->title,
            'description' => $hall->description,
            'category' => $category ? $category->name : '',
            'price' => $hall->price,
            'photo' => $hall->foto ? $host . $hall->foto : null,
        ];
    }

    /**
     * Загрузка и сохранение фото зала
     */
    private function handlePhotoUpload($hall, $isUpdate = false)
    {
        // Для PATCH/PUT запросов файл может не попасть в стандартные методы Yii2
        $hasFile = isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK;
        $file = null;
        
        if ($hasFile) {
            $fileInfo = $_FILES['photo'];
            $file = new UploadedFile();
            $file->name = $fileInfo['name'];
            $file->tempName = $fileInfo['tmp_name'];
            $file->type = $fileInfo['type'];
            $file->size = $fileInfo['size'];
            $file->error = $fileInfo['error'];
        } else {
            $file = UploadedFile::getInstance($hall, 'photo');
            if ($file === null) {
                $file = UploadedFile::getInstanceByName('photo');
            }
        }
        
        if ($file === null || ($file instanceof UploadedFile && $file->error !== UPLOAD_ERR_OK)) {
            return ['no_file' => true];
        }

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($file->type, $allowedTypes)) {
            Yii::$app->response->statusCode = 415;
            return [
                'error' => 'Unsupported file type'
            ];
        }

        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file->size > $maxSize) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'File size exceeds 5MB'
                ]
            ];
        }

        $uploadDir = Yii::getAlias('@webroot/uploads/halls');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if ($isUpdate && !empty($hall->foto)) {
            $oldFilePath = Yii::getAlias('@webroot') . $hall->foto;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        if (empty($hall->id_hall)) {
            return [
                'error' => 'Hall ID is required for photo upload'
            ];
        }
        
        $originalExtension = pathinfo($file->name, PATHINFO_EXTENSION);
        if (empty($originalExtension)) {
            if (strpos($file->type, 'jpeg') !== false || strpos($file->type, 'jpg') !== false) {
                $extension = 'jpg';
            } elseif (strpos($file->type, 'png') !== false) {
                $extension = 'png';
            } else {
                $extension = 'jpg';
            }
        } else {
            $extension = strtolower($originalExtension);
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $extension = 'jpg';
            }
        }
        
        // Генерируем имя файла на основе названия зала, ID и timestamp
        $hallId = $hall->id_hall;
        $hallTitle = !empty($hall->title) ? $hall->title : 'hall';
        $hallTitle = $this->transliterate($hallTitle);
        $hallTitle = preg_replace('/[^a-z0-9_-]/i', '_', $hallTitle);
        $hallTitle = preg_replace('/_+/', '_', $hallTitle);
        $hallTitle = trim($hallTitle, '_');
        if (empty($hallTitle)) {
            $hallTitle = 'hall';
        }
        
        $fileName = $hallTitle . '_' . $hallId . '_' . time() . '.' . $extension;
        $filePath = $uploadDir . '/' . $fileName;

        $saved = false;
        if (is_uploaded_file($file->tempName)) {
            $saved = @move_uploaded_file($file->tempName, $filePath);
        } else {
            if (file_exists($file->tempName)) {
                $saved = @copy($file->tempName, $filePath);
            }
        }
        
        if ($saved && file_exists($filePath)) {
            $photoUrl = '/uploads/halls/' . $fileName;
            $hall->foto = $photoUrl;
            
            if ($hall->foto !== $photoUrl) {
                $hall->setAttribute('foto', $photoUrl);
            }
            
            return true;
        }

        $errorMsg = 'Failed to upload file';
        $lastError = error_get_last();
        if ($lastError) {
            $errorMsg .= ': ' . $lastError['message'];
        }
        $errorMsg .= ' (tried to save as: ' . $fileName . ', temp file: ' . ($file->tempName ?? 'null') . ')';
        
        return [
            'error' => $errorMsg
        ];
    }

    /**
     * Транслитерация русских символов в латиницу
     */
    private function transliterate($text)
    {
        $translit = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];
        
        return strtr(mb_strtolower($text, 'UTF-8'), $translit);
    }

    /**
     * Удаление папки с фото зала
     */
    private function deleteHallPhotos($hallId)
    {
        $uploadDir = Yii::getAlias('@webroot/uploads/halls');
        $pattern = $uploadDir . '/hall' . $hallId . '_*';
        $files = glob($pattern);
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Просмотр списка залов
     * URL: GET /api/halls?category=Стандарт
     */
    public function actionIndex()
    {
        $categoryName = Yii::$app->request->get('category');
        $query = Halls::find()->with('category');

        if ($categoryName) {
            $category = Categories::find()
                ->where(['name' => $categoryName])
                ->one();

            if (!$category) {
                Yii::$app->response->statusCode = 400;
                return [
                    'error' => 'Unknown category'
                ];
            }

            $query->andWhere(['category_id' => $category->id_category]);
        }

        $halls = $query->all();
        $result = [];
        foreach ($halls as $hall) {
            $result[] = $this->formatHall($hall);
        }

        return $result;
    }

    /**
     * Получение информации о зале
     * URL: GET /api/halls/{id}
     */
    public function actionView($id)
    {
        $hall = Halls::findOne($id);
        if ($hall === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Hall not found'
            ];
        }

        return $this->formatHall($hall);
    }

    /**
     * Создание нового зала (только для админа)
     * URL: POST /api/halls
     * Body: multipart/form-data
     * - title, description, category_id, price (обязательно)
     * - photo (опционально, файл изображения)
     */
    public function actionCreate()
    {
        $this->checkAdmin();

        $data = Yii::$app->request->post();
        unset($data['foto']);
        
        $hall = new Halls();
        $hall->load($data, '');
        
        // Сначала сохраняем зал, чтобы получить ID для имени файла
        if (!$hall->validate() || !$hall->save()) {
            return $this->sendValidationError($hall);
        }
        
        $photoResult = $this->handlePhotoUpload($hall, false);
        if ($photoResult !== true) {
            $hall->delete();
            return $photoResult;
        }
        
        if (!$hall->save()) {
            return $this->sendValidationError($hall);
        }
        
        Yii::$app->response->statusCode = 201;
        return $this->formatHall($hall);
    }

    /**
     * Обновление информации о зале (только для админа)
     * URL: PUT /api/halls/{id}
     * Body: multipart/form-data
     * - title, description, category_id, price (опционально)
     * - photo (опционально, файл изображения)
     */
    public function actionUpdate($id)
    {
        $this->checkAdmin();

        $hall = Halls::findOne($id);
        
        if ($hall === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Hall not found'
            ];
        }

        $data = Yii::$app->request->post();
        unset($data['foto']);
        unset($data['photo']);
        
        $hall->load($data, '');

        if ($hall->validate() && $hall->save()) {
            $hall->refresh();
            return $this->formatHall($hall);
        } else {
            return $this->sendValidationError($hall);
        }
    }

    /**
     * Загрузка фото для зала (только для админа)
     * URL: POST /api/halls/{id}/photo
     * Body: multipart/form-data
     * - photo (обязательно, файл изображения)
     */
    public function actionUploadPhoto($id)
    {
        $this->checkAdmin();

        $hall = Halls::findOne($id);
        
        if ($hall === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Hall not found'
            ];
        }

        $photoResult = $this->handlePhotoUpload($hall, true);
        
        if ($photoResult !== true) {
            if (is_array($photoResult) && isset($photoResult['no_file'])) {
                Yii::$app->response->statusCode = 422;
                return [
                    'error' => [
                        'code' => 422,
                        'message' => 'Photo file is required'
                    ]
                ];
            }
            return $photoResult;
        }

        if ($hall->save()) {
            return $this->formatHall($hall);
        } else {
            return $this->sendValidationError($hall);
        }
    }

    /**
     * Удаление зала (только для админа)
     * URL: DELETE /api/halls/{id}
     */
    public function actionDelete($id)
    {
        $this->checkAdmin();

        $hall = Halls::findOne($id);
        
        if ($hall === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Hall not found'
            ];
        }

        $this->deleteHallPhotos($hall->id_hall);
        
        if (!empty($hall->foto)) {
            $filePath = Yii::getAlias('@webroot') . $hall->foto;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $hall->delete();
        Yii::$app->response->statusCode = 204;
        return null;
    }

    /**
     * Метод для обработки ошибок валидации
     */
    private function sendValidationError($model)
    {
        Yii::$app->response->statusCode = 422;
        return [
            'error' => [
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $model->errors,
            ]
        ];
    }
}
