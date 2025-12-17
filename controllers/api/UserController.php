<?php

namespace app\controllers\api;

use Yii;
use app\models\Users;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\web\UnsupportedMediaTypeHttpException;
use app\components\HttpBearerAuth;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\Users';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'optional' => ['create', 'login'],
        ];

        return $behaviors;
    }

    /**
     * Регистрация пользователя
     * URL: POST /api/register
     * Body: JSON
     * {
     *  "first_name": "Иван",
     *  "last_name": "Петров",
     *  "phone": "89001234568",
     *  "login": "ivanp",
     *  "password": "paSSword"
     * }
     */
    public function actionCreate()
    {
        $model = new Users();
        $model->load(Yii::$app->request->post(), '');

        if (empty($model->role)) {
            $model->role = Users::ROLE_USER;
        }

        if ($model->save()) {
            Yii::$app->response->statusCode = 204;
            return null;
        }

        Yii::$app->response->statusCode = 422;
        return [
            'error' => [
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $model->errors,
            ]
        ];
    }

    /**
     * Авторизация (получение JWT токена)
     * URL: POST /api/login
     * Body: JSON
     * {
     *  "login": "ivanp",
     *  "password": "paSSword"
     * }
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $login = $request->post('login');
        $password = $request->post('password');

        if (empty($login) || empty($password)) {
            Yii::$app->response->statusCode = 401;
            return [
                'error' => 'Invalid credentials'
            ];
        }

        $user = Users::findByLogin($login);
        if ($user === null || !$user->validatePassword($password)) {
            Yii::$app->response->statusCode = 401;
            return [
                'error' => 'Invalid credentials'
            ];
        }

        $jwtHelper = Yii::$app->jwt;
        $payload = [
            'user_id' => $user->id_user,
            'login' => $user->login,
            'role' => $user->role,
            'exp' => time() + (7 * 24 * 60 * 60) // токен действителен 7 дней
        ];
        $token = $jwtHelper->encode($payload);

        Yii::$app->response->statusCode = 200;
        return [
            'token' => $token
        ];
    }

    /**
     * Загрузка фотографии профиля
     * URL: POST /api/profile/avatar
     * Headers: Authorization: Bearer {token}
     * Body: multipart/form-data
     * file: <image>
     */
    public function actionUploadAvatar()
    {
        $user = Yii::$app->user->identity;
        if ($user === null) {
            Yii::$app->response->statusCode = 401;
            return [
                'error' => 'Unauthorized'
            ];
        }

        $file = UploadedFile::getInstanceByName('file');
        if ($file === null) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'File is required'
                ]
            ];
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

        $uploadDir = Yii::getAlias('@webroot/uploads/avatars');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!empty($user->avatar)) {
            $oldFilePath = Yii::getAlias('@webroot') . $user->avatar;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            
            $pattern = $uploadDir . '/user' . $user->id_user . '_*';
            $files = glob($pattern);
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }

        $extension = pathinfo($file->name, PATHINFO_EXTENSION);
        if (empty($extension)) {
            $extension = $file->extension ?: 'jpg';
        }
        $fileName = 'user' . $user->id_user . '_' . time() . '.' . $extension;
        $filePath = $uploadDir . '/' . $fileName;

        $saved = false;
        if (is_uploaded_file($file->tempName)) {
            $saved = move_uploaded_file($file->tempName, $filePath);
        } else {
            $saved = $file->saveAs($filePath);
        }
        
        if ($saved && file_exists($filePath)) {
            $avatarUrl = '/uploads/avatars/' . $fileName;
            $user->avatar = $avatarUrl;
            $user->save(false);

            $host = Yii::$app->request->hostInfo;
            $fullUrl = $host . $avatarUrl;

            Yii::$app->response->statusCode = 200;
            return [
                'url' => $fullUrl
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            $errorMsg = 'Failed to upload file';
            $lastError = error_get_last();
            if ($lastError) {
                $errorMsg .= ': ' . $lastError['message'];
            }
            return [
                'error' => $errorMsg
            ];
        }
    }

    /**
     * Получение профиля текущего пользователя
     * URL: GET /api/profile
     * Headers: Authorization: Bearer {token}
     */
    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        if ($user === null) {
            Yii::$app->response->statusCode = 401;
            return [
                'error' => 'Unauthorized'
            ];
        }

        return $user;
    }
}
