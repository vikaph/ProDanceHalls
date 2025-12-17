<?php

namespace app\controllers\api\admin;

use app\models\Users;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\components\HttpBearerAuth;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\Users';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
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

    public function beforeAction($action)
    {
        $this->checkAdmin();
        return parent::beforeAction($action);
    }

    /**
     * Форматирование пользователя для ответа
     */
    private function formatUser($user)
    {
        $host = Yii::$app->request->hostInfo;
        return [
            'id' => $user->id_user,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'login' => $user->login,
            'avatar' => $user->avatar ? $host . $user->avatar : null,
            'role' => $user->role,
            'created_at' => $user->created_at,
        ];
    }

    public function actionIndex()
    {
        $users = Users::find()->all();
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->formatUser($user);
        }
        return $result;
    }

    public function actionView($id)
    {
        $user = Users::findOne($id);
        if ($user === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'User not found'
            ];
        }
        return $this->formatUser($user);
    }

    /**
     * Блокировка пользователя
     * URL: POST /api/admin/users/{id}/block
     */
    public function actionBlock($id)
    {
        $user = Users::findOne($id);
        if ($user === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'User not found'
            ];
        }

        return [
            'id' => $user->id_user,
            'message' => 'User blocked successfully'
        ];
    }

    /**
     * Разблокировка пользователя
     * URL: POST /api/admin/users/{id}/unblock
     */
    public function actionUnblock($id)
    {
        $user = Users::findOne($id);
        if ($user === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'User not found'
            ];
        }

        return [
            'id' => $user->id_user,
            'message' => 'User unblocked successfully'
        ];
    }

    /**
     * Удаление пользователя (с удалением связанных файлов)
     * URL: DELETE /api/admin/users/{id}
     */
    public function actionDelete($id)
    {
        $user = Users::findOne($id);
        
        if ($user === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'User not found'
            ];
        }

        if (!empty($user->avatar)) {
            $filePath = Yii::getAlias('@webroot') . $user->avatar;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $uploadDir = Yii::getAlias('@webroot/uploads/avatars');
        $pattern = $uploadDir . '/user' . $user->id_user . '_*';
        $files = glob($pattern);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $user->delete();
        Yii::$app->response->statusCode = 204;
        return null;
    }
}

