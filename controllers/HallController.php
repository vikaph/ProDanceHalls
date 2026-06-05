<?php

namespace app\controllers;

use DateTime;
use Yii;
use app\models\Hall;
use app\models\HallSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * HallController implements the CRUD actions for Hall model.
 */
class HallController extends Controller
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
     * Lists all Hall models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new HallSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hall model.
     * @param int $id_hall Id Hall
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_hall)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_hall),
        ]);
    }

    /**
     * Creates a new Hall model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Hall();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_hall' => $model->id_hall]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Hall model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_hall Id Hall
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_hall)
    {
        $model = $this->findModel($id_hall);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_hall' => $model->id_hall]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Hall model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_hall Id Hall
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_hall)
    {
        $this->findModel($id_hall)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Hall model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_hall Id Hall
     * @return Hall the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_hall)
    {
        if (($model = Hall::findOne(['id_hall' => $id_hall])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBooking($id)
{
    $hall = Hall::findOne($id);

    // бронирования пользователей
    $bookings = (new \yii\db\Query())
        ->select(['date', 'time_slot'])
        ->from('booking_hall')
        ->where(['hall_id' => $id])
        ->all();

    //занятия из расписания
    $scheduleLessons = (new \yii\db\Query())
        ->select([
            'lesson_date as date',
            'lesson_time as time_slot'
        ])
        ->from('schedule')
        ->where(['hall_id' => $id])
        ->all();

    // время
    $bookings = array_map(function ($item) {
        $item['time_slot'] = substr($item['time_slot'], 0, 5);
        return $item;
    }, $bookings);

    $scheduleLessons = array_map(function ($item) {
        $item['time_slot'] = substr($item['time_slot'], 0, 5);
        return $item;
    }, $scheduleLessons);

    // объединяем занятые слоты
    $occupied = array_merge($bookings, $scheduleLessons);

    // все доступные часы
    $allSlots = [
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
        '18:00',
        '19:00',
        '20:00',
        '21:00',
    ];

    return $this->render('booking', [
        'hall' => $hall,
        'allSlots' => $allSlots,
        'occupied' => $occupied,
    ]);
}

public function actionSaveBooking()
{
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $hallId = Yii::$app->request->post('hall_id');
    $date = Yii::$app->request->post('date');
    $slots = Yii::$app->request->post('slots');

    if (!$slots) {

        Yii::$app->session->setFlash(
            'error',
            'Выберите хотя бы один слот'
        );

        return $this->redirect(['booking', 'id' => $hallId]);
    }

foreach ($slots as $slot) {

    // дата+время слота
    $slotDateTime = DateTime::createFromFormat(
        'Y-m-d H:i',
        $date . ' ' . $slot
    );

    // текущее время
    $now = new DateTime();

    // если слот в прошлом — пропускаем
    if ($slotDateTime < $now) {
        continue;
    }

    // проверка занятости
    $exists = (new \yii\db\Query())
        ->from('booking_hall')
        ->where([
            'hall_id' => $hallId,
            'date' => $date,
            'time_slot' => $slot,
        ])
        ->exists();

    if (!$exists) {

        Yii::$app->db->createCommand()->insert('booking_hall', [
            'user_id' => Yii::$app->user->id,
            'hall_id' => $hallId,
            'date' => $date,
            'time_slot' => $slot,
            'created_booking' => date('Y-m-d H:i:s'),
        ])->execute();
    }
}

    Yii::$app->session->setFlash(
        'success',
        'Зал успешно забронирован'
    );

    return $this->redirect(['hall/index']);
}
}
