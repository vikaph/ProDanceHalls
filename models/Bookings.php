<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings".
 *
 * @property int $id_booking
 * @property int $user_id
 * @property int $hall_id
 * @property string $date
 * @property string $time_slot
 * @property string $status
 * @property string $created_booking
 *
 * @property Halls $hall
 * @property Users $user
 */
class Bookings extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 'pending'],
            [['user_id', 'hall_id', 'date', 'time_slot'], 'required'],
            [['user_id', 'hall_id'], 'integer'],
            [['date', 'created_booking'], 'safe'],
            [['status'], 'string'],
            [['time_slot'], 'string', 'max' => 20],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Halls::class, 'targetAttribute' => ['hall_id' => 'id_hall']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id_user']],
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
            'status' => 'Status',
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
        return $this->hasOne(Halls::class, ['id_hall' => 'hall_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id_user' => 'user_id']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_PENDING => 'pending',
            self::STATUS_APPROVED => 'approved',
            self::STATUS_CANCELLED => 'cancelled',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isStatusApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function setStatusToApproved()
    {
        $this->status = self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isStatusCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function setStatusToCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
    }

    /**
     * Форматирование полей для API ответа
     */
    public function fields()
    {
        $fields = parent::fields();
        // Переименовываем id_booking в id для соответствия ТЗ
        $fields['id'] = 'id_booking';
        unset($fields['id_booking']);
        // Переименовываем time_slot в time
        $fields['time'] = 'time_slot';
        unset($fields['time_slot']);
        return $fields;
    }
}
