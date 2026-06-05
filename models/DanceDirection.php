<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dance_direction".
 *
 * @property int $id_dance_direction
 * @property string $name
 * @property string $description
 * @property string $image
 *
 * @property BookingFirstClass[] $bookingFirstClasses
 * @property Coach[] $coaches
 */
class DanceDirection extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dance_direction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'image'], 'required'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dance_direction' => 'Id Dance Direction',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[BookingFirstClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookingFirstClasses()
    {
        return $this->hasMany(BookingFirstClass::class, ['dance_direction_id' => 'id_dance_direction']);
    }

    /**
     * Gets query for [[Coaches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoaches()
    {
        return $this->hasMany(Coach::class, ['dance_direction_id' => 'id_dance_direction']);
    }

}
