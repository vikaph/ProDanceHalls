<?php

namespace app\controllers;

use app\models\BookingFirstClass;
use app\models\BookingFirstClassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookingFirstClassController implements the CRUD actions for BookingFirstClass model.
 */
class BookingFirstClassController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all BookingFirstClass models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookingFirstClassSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookingFirstClass model.
     * @param int $id_booking_first_class Id Booking First Class
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_booking_first_class)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_booking_first_class),
        ]);
    }

    /**
     * Creates a new BookingFirstClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BookingFirstClass();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_booking_first_class' => $model->id_booking_first_class]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookingFirstClass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_booking_first_class Id Booking First Class
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_booking_first_class)
    {
        $model = $this->findModel($id_booking_first_class);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_booking_first_class' => $model->id_booking_first_class]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookingFirstClass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_booking_first_class Id Booking First Class
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_booking_first_class)
    {
        $this->findModel($id_booking_first_class)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BookingFirstClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_booking_first_class Id Booking First Class
     * @return BookingFirstClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_booking_first_class)
    {
        if (($model = BookingFirstClass::findOne(['id_booking_first_class' => $id_booking_first_class])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
