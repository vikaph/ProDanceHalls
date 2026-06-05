<?php

namespace app\models;

use yii\db\ActiveRecord;

class BookingFirstClass extends ActiveRecord
{
    public static function tableName()
    {
        return 'booking_first_class';
    }

   public function rules()
{
    return [
        [['name', 'phone'], 'required',
            'message' => 'Заполните поле'
        ],

        ['name', 'match',
            'pattern' => '/^[a-zA-Zа-яА-ЯёЁ\s]+$/u',
            'message' => 'Имя должно содержать только буквы'
        ],

        ['phone', 'match',
            'pattern' => '/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
            'message' => 'Введите телефон в формате +7 (999) 999-99-99'
        ],
    ];
}
}