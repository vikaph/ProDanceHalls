<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hall".
 *
 * @property int $id_hall
 * @property string $title
 * @property string $description
 * @property string $foto
 * @property string $price
 * @property string $size
 *
 * @property BookingHall[] $bookingHalls
 */
class Hall extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'foto', 'price', 'size'], 'required'],
            [['description'], 'string'],
            [['title', 'foto'], 'string', 'max' => 255],
            [['price', 'size'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_hall' => 'Id Hall',
            'title' => 'Title',
            'description' => 'Description',
            'foto' => 'Foto',
            'price' => 'Price',
            'size' => 'Size',
        ];
    }

    /**
     * Gets query for [[BookingHalls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookingHalls()
    {
        return $this->hasMany(BookingHall::class, ['hall_id' => 'id_hall']);
    }

}
