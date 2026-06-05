<?php

namespace app\controllers;

use Yii;
use app\models\DanceDirection;
use app\models\DanceDirectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * DanceDirectionController implements the CRUD actions for DanceDirection model.
 */
class DanceDirectionController extends Controller
{
    public function behaviors()
{
    return array_merge(
        parent::behaviors(),
        [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   
                    'enroll' => ['POST'],
                ],
            ],

            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->is_admin == 1;
                        }
                    ],
                ],
            ],
        ]
    );
}

    /**
     * Lists all DanceDirection models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DanceDirectionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DanceDirection model.
     * @param int $id_dance_direction Id Dance Direction
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_dance_direction)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_dance_direction),
        ]);
    }

    /**
     * Creates a new DanceDirection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DanceDirection();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_dance_direction' => $model->id_dance_direction]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DanceDirection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_dance_direction Id Dance Direction
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_dance_direction)
    {
        $model = $this->findModel($id_dance_direction);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_dance_direction' => $model->id_dance_direction]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DanceDirection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_dance_direction Id Dance Direction
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_dance_direction)
    {
        $this->findModel($id_dance_direction)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DanceDirection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_dance_direction Id Dance Direction
     * @return DanceDirection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_dance_direction)
    {
        if (($model = DanceDirection::findOne(['id_dance_direction' => $id_dance_direction])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
