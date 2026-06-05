<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coach".
 *
 * @property int $id_coach
 * @property string $fio
 * @property string $description
 * @property int $dance_direction_id
 * @property string $foto
 *
 * @property DanceDirection $danceDirection
 */
class Coach extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'description', 'dance_direction_id', 'foto'], 'required'],
            [['description'], 'string'],
            [['dance_direction_id'], 'integer'],
            [['fio', 'foto'], 'string', 'max' => 255],
            [['dance_direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => DanceDirection::class, 'targetAttribute' => ['dance_direction_id' => 'id_dance_direction']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_coach' => 'Id Coach',
            'fio' => 'Fio',
            'description' => 'Description',
            'dance_direction_id' => 'Dance Direction ID',
            'foto' => 'Foto',
        ];
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

}
