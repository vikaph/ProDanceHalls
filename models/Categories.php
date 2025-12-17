<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories".
 *
 * @property int $id_category
 * @property string $name
 *
 * @property Halls[] $halls
 */
class Categories extends ActiveRecord
{

    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_category' => 'Id Category',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Halls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHalls()
    {
        return $this->hasMany(Halls::class, ['category_id' => 'id_category']);
    }

}
