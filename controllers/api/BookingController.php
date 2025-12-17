<?php

namespace app\controllers\api;

use app\models\Bookings;
use app\models\Halls;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\ConflictHttpException;
use app\components\HttpBearerAuth;
use Yii;

class BookingController extends ActiveController
{
    public $modelClass = 'app\models\Bookings';

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

    /**
     * Форматирование бронирования для ответа
     */
    private function formatBooking($booking)
    {
        return [
            'id' => $booking->id_booking,
            'user_id' => $booking->user_id,
            'hall_id' => $booking->hall_id,
            'date' => $booking->date,
            'time' => $booking->time_slot,
            'status' => $booking->status,
            'created_booking' => $booking->created_booking,
        ];
    }

    /**
     * Проверка доступности слота
     */
    private function isSlotAvailable($hallId, $date, $time)
    {
        $existing = Bookings::find()
            ->where([
                'hall_id' => $hallId,
                'date' => $date,
                'time_slot' => $time,
            ])
            ->andWhere(['!=', 'status', Bookings::STATUS_CANCELLED])
            ->one();

        return $existing === null;
    }

    /**
     * Создание бронирования
     * URL: POST /api/bookings
     * Body: JSON
     * {
     *  "hall_id": 1,
     *  "date": "2025-01-10",
     *  "time": "15:00"
     * }
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $data = Yii::$app->request->post();

        $hallId = isset($data['hall_id']) ? (int)$data['hall_id'] : null;
        $date = isset($data['date']) ? $data['date'] : null;
        $time = isset($data['time']) ? $data['time'] : null;

        if (empty($hallId) || empty($date) || empty($time)) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => [
                        'hall_id' => $hallId ? [] : ['Hall ID is required'],
                        'date' => $date ? [] : ['Date is required'],
                        'time' => $time ? [] : ['Time is required'],
                    ]
                ]
            ];
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => ['date' => ['Invalid date format. Use YYYY-MM-DD']]
                ]
            ];
        }

        if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => ['time' => ['Invalid time format. Use HH:MM']]
                ]
            ];
        }

        $hall = Halls::findOne($hallId);
        if ($hall === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Hall not found'
            ];
        }

        // Проверка доступности слота
        if (!$this->isSlotAvailable($hallId, $date, $time)) {
            Yii::$app->response->statusCode = 409;
            return [
                'error' => 'Slot already booked'
            ];
        }

        $booking = new Bookings();
        $booking->user_id = $user->id_user;
        $booking->hall_id = $hallId;
        $booking->date = $date;
        $booking->time_slot = $time;
        $booking->status = Bookings::STATUS_PENDING;

        if ($booking->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'id' => $booking->id_booking,
                'status' => $booking->status
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $booking->errors
                ]
            ];
        }
    }

    /**
     * Просмотр своих бронирований
     * URL: GET /api/bookings
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $isAdmin = $user->isRoleAdmin();

        if ($isAdmin) {
            $bookings = Bookings::find()->orderBy(['created_booking' => SORT_DESC])->all();
        } else {
            $bookings = Bookings::find()
                ->where(['user_id' => $user->id_user])
                ->orderBy(['created_booking' => SORT_DESC])
                ->all();
        }

        $result = [];
        foreach ($bookings as $booking) {
            $result[] = $this->formatBooking($booking);
        }

        return $result;
    }

    /**
     * Просмотр конкретного бронирования
     * URL: GET /api/bookings/{id}
     */
    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $booking = Bookings::findOne($id);

        if ($booking === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Booking not found'
            ];
        }

        if (!$user->isRoleAdmin() && $booking->user_id !== $user->id_user) {
            Yii::$app->response->statusCode = 403;
            return [
                'error' => 'Forbidden'
            ];
        }

        return $this->formatBooking($booking);
    }

    /**
     * Изменение бронирования (PATCH)
     * URL: PATCH /api/bookings/{id}
     * Body: JSON
     * {
     *  "date": "2025-01-12",
     *  "time": "14:00"
     * }
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $booking = Bookings::findOne($id);

        if ($booking === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Booking not found'
            ];
        }

        // Пользователь может изменять только свои бронирования
        if (!$user->isRoleAdmin() && $booking->user_id !== $user->id_user) {
            Yii::$app->response->statusCode = 403;
            return [
                'error' => 'Forbidden'
            ];
        }

        if ($booking->status === Bookings::STATUS_APPROVED) {
            Yii::$app->response->statusCode = 403;
            return [
                'error' => 'Cannot modify approved booking'
            ];
        }

        $data = Yii::$app->request->getBodyParams();
        $newDate = isset($data['date']) ? $data['date'] : $booking->date;
        $newTime = isset($data['time']) ? $data['time'] : $booking->time_slot;
        $newHallId = isset($data['hall_id']) ? (int)$data['hall_id'] : $booking->hall_id;

        if (isset($data['date']) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $newDate)) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => ['date' => ['Invalid date format. Use YYYY-MM-DD']]
                ]
            ];
        }

        if (isset($data['time']) && !preg_match('/^\d{2}:\d{2}$/', $newTime)) {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => ['time' => ['Invalid time format. Use HH:MM']]
                ]
            ];
        }

        if (($newDate !== $booking->date || $newTime !== $booking->time_slot || $newHallId !== $booking->hall_id)) {
            if (!$this->isSlotAvailable($newHallId, $newDate, $newTime)) {
                Yii::$app->response->statusCode = 409;
                return [
                    'error' => 'New slot unavailable'
                ];
            }

            $booking->hall_id = $newHallId;
            $booking->date = $newDate;
            $booking->time_slot = $newTime;
            $booking->status = Bookings::STATUS_PENDING; // статус сбрасывается при изменении
        }

        if ($booking->save()) {
            return [
                'id' => $booking->id_booking,
                'status' => $booking->status
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            return [
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $booking->errors
                ]
            ];
        }
    }

    /**
     * Отмена бронирования пользователем
     * URL: DELETE /api/bookings/{id}
     */
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $booking = Bookings::findOne($id);

        if ($booking === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Booking not found'
            ];
        }

        // Пользователь может удалять только свои бронирования
        if (!$user->isRoleAdmin() && $booking->user_id !== $user->id_user) {
            Yii::$app->response->statusCode = 403;
            return [
                'error' => 'Forbidden'
            ];
        }

        // Нельзя отменить подтверждённое бронирование
        if ($booking->status === Bookings::STATUS_APPROVED) {
            Yii::$app->response->statusCode = 403;
            return [
                'error' => 'Cannot cancel approved booking'
            ];
        }

        // Отменяем бронирование (меняем статус на cancelled)
        $booking->status = Bookings::STATUS_CANCELLED;
        $booking->save(false);

        return [
            'id' => $booking->id_booking,
            'status' => $booking->status,
            'message' => 'Booking cancelled successfully'
        ];
    }

    /**
     * Подтверждение бронирования админом
     * URL: POST /api/admin/bookings/{id}/approve
     */
    public function actionApprove($id)
    {
        $this->checkAdmin();

        $booking = Bookings::findOne($id);

        if ($booking === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Booking not found'
            ];
        }

        $booking->status = Bookings::STATUS_APPROVED;
        $booking->save(false);

        return [
            'id' => $booking->id_booking,
            'status' => $booking->status,
            'message' => 'Booking approved successfully'
        ];
    }

    /**
     * Удаление бронирования админом
     * URL: DELETE /api/admin/bookings/{id}
     */
    public function actionAdminDelete($id)
    {
        $this->checkAdmin();

        $booking = Bookings::findOne($id);

        if ($booking === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => 'Booking not found'
            ];
        }

        $booking->delete();
        Yii::$app->response->statusCode = 204;
        return null;
    }

}
