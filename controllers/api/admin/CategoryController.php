<?php

namespace app\controllers\api\admin;

use app\models\Categories;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\components\HttpBearerAuth;
use Yii;

class CategoryController extends ActiveController
{
    public $modelClass = 'app\models\Categories';

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
     * Форматирование категории для ответа
     */
    private function formatCategory($category)
    {
        return [
            'id' => $category->id_category,
            'name' => $category->name,
        ];
    }

    public function actionIndex()
    {
        $categories = Categories::find()->all();
        $result = [];
        foreach ($categories as $category) {
            $result[] = $this->formatCategory($category);
        }
        return $result;
    }

    public function actionView($id)
    {
        $category = Categories::findOne($id);
        if ($category === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Category not found'
            ];
        }
        return $this->formatCategory($category);
    }

    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $category = new Categories();
        
        $category->load($data, '');
        
        if ($category->validate() && $category->save()) {
            Yii::$app->response->statusCode = 201;
            return $this->formatCategory($category);
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $category->errors,
                ]
            ];
        }
    }

    public function actionUpdate($id)
    {
        $category = Categories::findOne($id);
        
        if ($category === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Category not found'
            ];
        }

        $data = Yii::$app->request->getBodyParams();
        $category->load($data, '');

        if ($category->validate() && $category->save()) {
            return $this->formatCategory($category);
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $category->errors,
                ]
            ];
        }
    }

    public function actionDelete($id)
    {
        $category = Categories::findOne($id);
        
        if ($category === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Category not found'
            ];
        }

        $hallsCount = \app\models\Halls::find()->where(['category_id' => $id])->count();
        if ($hallsCount > 0) {
            Yii::$app->response->statusCode = 409;
            return [
                'error' => 'Cannot delete category with existing halls'
            ];
        }

        $category->delete();
        Yii::$app->response->statusCode = 204;
        return null;
    }
}

