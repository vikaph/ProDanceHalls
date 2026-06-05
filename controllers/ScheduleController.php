<?php

namespace app\controllers;

use app\models\Schedule;
use Yii;
use DateTime;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class ScheduleController extends Controller
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

    public function actionIndex()
    {
        // неделя (переключение стрелками)
        $weekOffset = Yii::$app->request->get('week', 0);

        $directionFilter = Yii::$app->request->get('direction');
        $coachFilter = Yii::$app->request->get('coach');
        $groupFilter = Yii::$app->request->get('group');

        // старт недели (понедельник)
        $startDate = new DateTime();
        $startDate->modify('monday this week');
        $startDate->modify("+{$weekOffset} week");

        // формируем 7 дней
        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $day = clone $startDate;
            $day->modify("+{$i} day");

            $days[] = [
                'date' => $day->format('Y-m-d'),
                'label' => $day->format('d') . ' ' . $this->getMonthName((int)$day->format('m')),
                'weekday' => $this->getWeekdayName((int)$day->format('N')),
            ];
        }

        // расписание
       $query = Schedule::find()
    ->with(['danceDirection', 'coach']);

        if ($directionFilter) {
    $query->andWhere(['dance_direction_id' => $directionFilter]);
            }

        if ($coachFilter) {
    $query->andWhere(['coach_id' => $coachFilter]);
            }

        if ($groupFilter) {
    $query->andWhere(['group_type' => $groupFilter]);
            }

        $schedules = $query->all();

        // время
        $times = [
            '10:00:00',
            '11:00:00',
            '12:00:00',
            '13:00:00',
            '14:00:00',
            '15:00:00',
            '16:00:00',
            '17:00:00',
            '18:00:00',
            '19:00:00',
            '20:00:00',
            '21:00:00',
        ];

        return $this->render('index', [
            'schedules' => $schedules,
            'days' => $days,
            'times' => $times,
            'weekOffset' => $weekOffset, 
            'directionFilter' => $directionFilter,
            'coachFilter' => $coachFilter,
            'groupFilter' => $groupFilter,
        ]);
    }

    private function getWeekdayName($n)
    {
        $days = [
            1 => 'пн',
            2 => 'вт',
            3 => 'ср',
            4 => 'чт',
            5 => 'пт',
            6 => 'сб',
            7 => 'вс',
        ];

        return $days[$n];
    }

    private function getMonthName($m)
    {
        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];

        return $months[$m];
    }

  public function actionView($id_schedule)
{
    $model = $this->findModel($id_schedule);

    $isBooked = false;

    if (!Yii::$app->user->isGuest) {
        $isBooked = (new \yii\db\Query())
            ->from('booking_lesson')
            ->where([
                'user_id' => Yii::$app->user->id,
                'schedule_id' => $id_schedule,
            ])
            ->exists();
    }

    return $this->render('view', [
        'model' => $model,
        'isBooked' => $isBooked,
    ]);
}

    public function actionCreate()
    {
        $model = new Schedule();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_schedule' => $model->id_schedule]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id_schedule)
    {
        $model = $this->findModel($id_schedule);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_schedule' => $model->id_schedule]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id_schedule)
    {
        $this->findModel($id_schedule)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id_schedule)
    {
        if (($model = Schedule::findOne(['id_schedule' => $id_schedule])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


public function actionEnroll()
{
    $scheduleId = Yii::$app->request->post('schedule_id');

$schedule = \app\models\Schedule::findOne($scheduleId);

if (!$schedule) {
    throw new \yii\web\NotFoundHttpException('Занятие не найдено');
}

// ПРОВЕРКА НА ПРОШЕДШЕЕ ВРЕМЯ
if (strtotime($schedule->lesson_date . ' ' . $schedule->lesson_time) < time()) {
    Yii::$app->session->setFlash('error', 'Нельзя записаться на прошедшее занятие');
    return $this->redirect(['view', 'id_schedule' => $scheduleId]);
}
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $scheduleId = Yii::$app->request->post('schedule_id');

    // проверка: чтобы не записывался 2 раза
    $exists = (new \yii\db\Query())
        ->from('booking_lesson')
        ->where([
            'user_id' => Yii::$app->user->id,
            'schedule_id' => $scheduleId,
        ])
        ->exists();

    if ($exists) {
        Yii::$app->session->setFlash('info', 'Вы уже записаны на это занятие');
        return $this->redirect(['view', 'id_schedule' => $scheduleId]);
    }

    // запись
    Yii::$app->db->createCommand()->insert('booking_lesson', [
        'user_id' => Yii::$app->user->id,
        'schedule_id' => $scheduleId,
        'created_at' => date('Y-m-d H:i:s'),
    ])->execute();

    Yii::$app->session->setFlash('success', 'Вы успешно записаны');

    return $this->redirect(['view', 'id_schedule' => $scheduleId]);
}

}