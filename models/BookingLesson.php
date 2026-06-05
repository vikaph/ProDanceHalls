<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booking_lesson".
 *
 * @property int $id_booking_lesson
 * @property int $user_id
 * @property int $schedule_id
 * @property string $created_at
 *
 * @property Schedule $schedule
 * @property User $user
 */
class BookingLesson extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking_lesson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'schedule_id'], 'required'],
            [['user_id', 'schedule_id'], 'integer'],
            [['created_at'], 'safe'],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Schedule::class, 'targetAttribute' => ['schedule_id' => 'id_schedule']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id_user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_booking_lesson' => 'Id Booking Lesson',
            'user_id' => 'User ID',
            'schedule_id' => 'Schedule ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Schedule]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::class, ['id_schedule' => 'schedule_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id_user' => 'user_id']);
    }

}
