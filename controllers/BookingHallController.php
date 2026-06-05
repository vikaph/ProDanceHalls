<?php

namespace app\controllers;

use app\models\BookingHall;
use app\models\BookingHallSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookingHallController implements the CRUD actions for BookingHall model.
 */
class BookingHallController extends Controller
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
     * Lists all BookingHall models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookingHallSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookingHall model.
     * @param int $id_booking Id Booking
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_booking)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_booking),
        ]);
    }

    /**
     * Creates a new BookingHall model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BookingHall();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_booking' => $model->id_booking]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookingHall model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_booking Id Booking
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_booking)
    {
        $model = $this->findModel($id_booking);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_booking' => $model->id_booking]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookingHall model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_booking Id Booking
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_booking)
    {
        $this->findModel($id_booking)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BookingHall model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_booking Id Booking
     * @return BookingHall the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_booking)
    {
        if (($model = BookingHall::findOne(['id_booking' => $id_booking])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
