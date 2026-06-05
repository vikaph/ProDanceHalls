<?php

namespace app\controllers;

use yii\data\Pagination;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\db\Query;
use app\models\Schedule;
use app\models\Coach;
use app\models\DanceDirection;
use app\models\Hall;

class AdminController extends Controller
{
    /**
     * Защита админки
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->is_admin != 1) {
            throw new ForbiddenHttpException('Доступ запрещён');
        }

        return parent::beforeAction($action);
    }

    /**
     *  Главная админ-панель
     */
   public function actionIndex()
{

    // ФИЛЬТРЫ

    $searchName = Yii::$app->request->get('name');
    $searchPhone = Yii::$app->request->get('phone');
    $searchDate = Yii::$app->request->get('date');
    $searchGroup = Yii::$app->request->get('group');
    $searchDirection = Yii::$app->request->get('direction');

  
    // ЗАПИСИ НА ЗАНЯТИЯ

    $lessonQuery = (new \yii\db\Query())
        ->select([
            'bl.id_booking_lesson',
            'bl.user_id',
            'u.fio as user_name',
            'u.phone as user_phone',
            's.lesson_date',
            's.lesson_time',
            's.group_type',
            'd.name as direction_name'
        ])
        ->from('booking_lesson bl')
        ->leftJoin('user u', 'u.id_user = bl.user_id')
        ->leftJoin('schedule s', 's.id_schedule = bl.schedule_id')
        ->leftJoin(
            'dance_direction d',
            'd.id_dance_direction = s.dance_direction_id'
        );

    // ФИЛЬТРЫ
    if ($searchName) {
        $lessonQuery->andWhere(['like', 'u.fio', $searchName]);
    }

    if ($searchPhone) {
        $lessonQuery->andWhere(['like', 'u.phone', $searchPhone]);
    }

    if ($searchDate) {
        $lessonQuery->andWhere(['s.lesson_date' => $searchDate]);
    }

    if ($searchGroup) {
        $lessonQuery->andWhere(['s.group_type' => $searchGroup]);
    }

    if ($searchDirection) {
        $lessonQuery->andWhere(['like', 'd.name', $searchDirection]);
    }

    //ПАГИНАЦИЯ
    $lessonCount = $lessonQuery->count();
    $lessonPages = new Pagination([
        'totalCount' => $lessonCount,
        'pageSize' => 5,
    ]);
    $lessonBookings = $lessonQuery
        ->offset($lessonPages->offset)
        ->limit($lessonPages->limit)
        ->all();


        $directions = (new \yii\db\Query())
        ->select(['id_dance_direction', 'name'])
        ->from('dance_direction')
        ->all();


    // БРОНИ ЗАЛОВ
    $searchName = Yii::$app->request->get('name');
$searchPhone = Yii::$app->request->get('phone');
$searchDate = Yii::$app->request->get('date');
$searchHall = Yii::$app->request->get('hall');
$searchTime = Yii::$app->request->get('time');

$hallQuery = (new \yii\db\Query())
    ->select([
        'bh.*',
        'u.fio as user_name',
        'u.phone as user_phone',
        'h.title as hall_name'
    ])
    ->from('booking_hall bh')
    ->leftJoin('user u', 'u.id_user = bh.user_id')
    ->leftJoin('hall h', 'h.id_hall = bh.hall_id');

// ФИЛЬТРЫ
if ($searchName) {
    $hallQuery->andWhere(['like', 'u.fio', $searchName]);
}

if ($searchPhone) {
    $hallQuery->andWhere(['like', 'u.phone', $searchPhone]);
}

if ($searchDate) {
    $hallQuery->andWhere(['bh.date' => $searchDate]);
}

if ($searchHall) {
    $hallQuery->andWhere(['bh.hall_id' => $searchHall]);
}

if ($searchTime) {
    $hallQuery->andWhere(['bh.time_slot' => $searchTime]);
}

// ПАГИНАЦИЯ
$hallCount = $hallQuery->count();

$hallPages = new \yii\data\Pagination([
    'totalCount' => $hallCount,
    'pageSize' => 5,
]);

$hallBookings = $hallQuery
    ->offset($hallPages->offset)
    ->limit($hallPages->limit)
    ->all();

// список залов для dropdown
$halls = (new \yii\db\Query())
    ->select([
        'id_hall',
        'title',
        'description',
        'size',
        'price',
        'foto'
    ])
    ->from('hall')
    ->all();

    // ПРОБНЫЕ ЗАЯВКИ

    $searchStatus = Yii::$app->request->get('status');

    $firstQuery = (new \yii\db\Query())
        ->from('booking_first_class');

    if ($searchStatus) {
        $firstQuery->andWhere(['status' => $searchStatus]);
    }

    $firstClassRequests = $firstQuery->all();

    $directionsList = \app\models\DanceDirection::find()->all();

    $coaches = \app\models\Coach::find()->all();

   

    $users = \app\models\User::find()->all();

    // ===================== РАСПИСАНИЕ =====================

$scheduleDirection = Yii::$app->request->get('schedule_direction');
$scheduleCoach = Yii::$app->request->get('schedule_coach');
$scheduleHall = Yii::$app->request->get('schedule_hall');
$scheduleDate = Yii::$app->request->get('schedule_date');

$scheduleQuery = (new \yii\db\Query())
    ->from('schedule s')
    ->leftJoin('dance_direction d', 'd.id_dance_direction = s.dance_direction_id')
    ->leftJoin('coach c', 'c.id_coach = s.coach_id')
    ->leftJoin('hall h', 'h.id_hall = s.hall_id')
    ->select([
        's.*',
        'd.name AS direction_name',
        'c.fio AS coach_name',
        'h.title AS hall_name'
    ]);

if ($scheduleDirection) {
    $scheduleQuery->andWhere(['s.dance_direction_id' => $scheduleDirection]);
}

if ($scheduleCoach) {
    $scheduleQuery->andWhere(['s.coach_id' => $scheduleCoach]);
}

if ($scheduleHall) {
    $scheduleQuery->andWhere(['s.hall_id' => $scheduleHall]);
}

if ($scheduleDate) {
    $scheduleQuery->andWhere(['s.lesson_date' => $scheduleDate]);
}

$scheduleCount = $scheduleQuery->count();

$schedulePages = new Pagination([
    'totalCount' => $scheduleCount,
    'pageSize' => 20,
]);

$schedules = $scheduleQuery
    ->offset($schedulePages->offset)
    ->limit($schedulePages->limit)
    ->all();

    $directions = (new \yii\db\Query())
    ->select(['id_dance_direction', 'name'])
    ->from('dance_direction')
    ->all();


    return $this->render('index', [
        'lessonBookings' => $lessonBookings,
        'hallBookings' => $hallBookings,
        'firstClassRequests' => $firstClassRequests,
        'directions' => $directions,
        'lessonPages' => $lessonPages,
        'hallPages' => $hallPages,
        'halls' => $halls,
        'directionsList' => $directionsList,
        'coaches' => $coaches,
        'schedules' => $schedules,
        'users' => $users,
        'schedulePages' => $schedulePages,
    ]);
}

    /**
     *  Удаление записи на занятие
     */
    public function actionDeleteLesson($id)
    {
        Yii::$app->db->createCommand()
            ->delete('booking_lesson', ['id_booking_lesson' => $id])
            ->execute();

        Yii::$app->session->setFlash('success', 'Запись удалена');

        return $this->redirect(['index']);
    }

    /**
     * Удаление брони зала
     */
    public function actionDeleteHall($id)
    {
        Yii::$app->db->createCommand()
            ->delete('booking_hall', ['id_booking' => $id])
            ->execute();

        Yii::$app->session->setFlash('success', 'Бронь удалена');

        return $this->redirect(['index']);
    }

    /**
     *  Обновление статуса заявки на пробное занятие
     */
    public function actionUpdateStatus()
    {
        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');

        Yii::$app->db->createCommand()
            ->update('booking_first_class', [
                'status' => $status
            ], [
                'id_booking_first_class' => $id
            ])
            ->execute();

        Yii::$app->session->setFlash('success', 'Статус обновлён');

        return $this->redirect(['index']);
    }


    public function actionUpdateLesson($id)
{
    $booking = (new \yii\db\Query())
        ->from('booking_lesson')
        ->where(['id_booking_lesson' => $id])
        ->one();

    if (!$booking) {
        throw new \yii\web\NotFoundHttpException('Не найдено');
    }

    return $this->render('update-lesson', [
        'model' => $booking
    ]);
}

public function actionSaveLessonUpdate()
{
    $id = Yii::$app->request->post('id');
    $status = Yii::$app->request->post('status');

    Yii::$app->db->createCommand()->update('booking_lesson', [
        'status' => $status
    ], [
        'id_booking_lesson' => $id
    ])->execute();

    Yii::$app->session->setFlash('success', 'Заявка обновлена');

    return $this->redirect(['index']);
}
}
