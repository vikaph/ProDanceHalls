<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "halls".
 *
 * @property int $id_hall
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $price
 * @property string $foto
 *
 * @property Bookings[] $bookings
 * @property Categories $category
 */
class Halls extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'halls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'price'], 'required'],
            [['description'], 'string'],
            [['category_id', 'price'], 'integer'],
            [['title'], 'string', 'max' => 150],
            [['foto'], 'string', 'max' => 255],
            [['foto'], 'default', 'value' => ''],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id_category']],
            // photo - виртуальное поле для загрузки файла (не сохраняется в БД напрямую)
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png', 'maxSize' => 5 * 1024 * 1024],
        ];
    }
    
    /**
     * Виртуальный атрибут для загрузки фото
     */
    public $photo;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_hall' => 'Id Hall',
            'title' => 'Title',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'price' => 'Price',
            'foto' => 'Foto',
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Bookings::class, ['hall_id' => 'id_hall']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id_category' => 'category_id']);
    }

    /**
     * Форматирование полей для API ответа
     */
    public function fields()
    {
        $fields = parent::fields();
        // Переименовываем id_hall в id для соответствия ТЗ
        $fields['id'] = 'id_hall';
        unset($fields['id_hall']);
        return $fields;
    }

    /**
     * Дополнительные поля для API
     */
    public function extraFields()
    {
        return ['category'];
    }
}

