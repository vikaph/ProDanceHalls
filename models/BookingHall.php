<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booking_hall".
 *
 * @property int $id_booking
 * @property int $user_id
 * @property int $hall_id
 * @property string $date
 * @property string $time_slot
 * @property string $created_booking
 *
 * @property Hall $hall
 * @property User $user
 */
class BookingHall extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking_hall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'hall_id', 'date', 'time_slot'], 'required'],
            [['user_id', 'hall_id'], 'integer'],
            [['date', 'created_booking'], 'safe'],
            [['time_slot'], 'string', 'max' => 20],
            [['hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hall::class, 'targetAttribute' => ['hall_id' => 'id_hall']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id_user']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_booking' => 'Id Booking',
            'user_id' => 'User ID',
            'hall_id' => 'Hall ID',
            'date' => 'Date',
            'time_slot' => 'Time Slot',
            'created_booking' => 'Created Booking',
        ];
    }

    /**
     * Gets query for [[Hall]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHall()
    {
        return $this->hasOne(Hall::class, ['id_hall' => 'hall_id']);
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
