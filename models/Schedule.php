<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property int $id_schedule
 * @property int $dance_direction_id
 * @property int $coach_id
 * @property string $lesson_date
 * @property string $lesson_time
 * @property int $hall_id
 * @property int $max_people
 * @property string $group_type
 *
 * @property BookingLesson[] $bookingLessons
 * @property Coach $coach
 * @property DanceDirection $danceDirection
 * @property Hall $hall
 */
class Schedule extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dance_direction_id', 'coach_id', 'lesson_date', 'lesson_time', 'hall_id', 'max_people', 'group_type'], 'required'],
            [['dance_direction_id', 'coach_id', 'hall_id', 'max_people'], 'integer'],
            [['lesson_date', 'lesson_time'], 'safe'],
            [['group_type'], 'string', 'max' => 20],
            [['coach_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coach::class, 'targetAttribute' => ['coach_id' => 'id_coach']],
            [['dance_direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanceDirection::class, 'targetAttribute' => ['dance_direction_id' => 'id_dance_direction']],
            [['hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hall::class, 'targetAttribute' => ['hall_id' => 'id_hall']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_schedule' => 'Id Schedule',
            'dance_direction_id' => 'Dance Direction ID',
            'coach_id' => 'Coach ID',
            'lesson_date' => 'Lesson Date',
            'lesson_time' => 'Lesson Time',
            'hall_id' => 'Hall ID',
            'max_people' => 'Max People',
            'group_type' => 'Group Type',
        ];
    }

    /**
     * Gets query for [[BookingLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookingLessons()
    {
        return $this->hasMany(BookingLesson::class, ['schedule_id' => 'id_schedule']);
    }

    /**
     * Gets query for [[Coach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoach()
    {
        return $this->hasOne(Coach::class, ['id_coach' => 'coach_id']);
    }

    /**
     * Gets query for [[DanceDirection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDanceDirection()
    {
        return $this->hasOne(DanceDirection::class, ['id_dance_direction' => 'dance_direction_id']);
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

}
