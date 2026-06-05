<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id_user
 * @property string $fio
 * @property string $phone
 * @property string $login
 * @property string $password
 * @property string $created_at
 * @property int $is_admin
 *
 * @property BookingFirstClass[] $bookingFirstClasses
 * @property BookingHall[] $bookingHalls
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['is_admin'], 'default', 'value' => 0],

        [['created_at'], 'safe'],
        [['is_admin'], 'integer'],

        // обязательные поля
        [
            ['fio'],
            'required',
            'message' => 'Введите ФИО'
        ],
        [
            ['phone'],
            'required',
            'message' => 'Введите телефон'
        ],
        [
            ['login'],
            'required',
            'message' => 'Введите логин'
        ],
        [
            ['password'],
            'required',
            'message' => 'Введите пароль'
        ],

        // ФИО — только буквы и пробелы 
        [
            ['fio'],
            'match',
            'pattern' => '/^[a-zA-Zа-яА-ЯёЁ\s]+$/u',
            'message' => 'ФИО может содержать только буквы'
        ],

        // телефон 
        [
            ['phone'],
            'match',
            'pattern' => '/^\+?[0-9\-\(\)\s]{10,20}$/',
            'message' => 'Введите корректный номер телефона'
        ],

        // логин — только английские буквы и цифры
        [
            ['login'],
            'match',
            'pattern' => '/^[a-zA-Z0-9]+$/',
            'message' => 'Логин должен содержать только латинские буквы и цифры'
        ],

        // уникальность логина
        [
            ['login'],
            'unique',
            'message' => 'Этот логин уже занят'
        ],

        // пароль — буквы + цифры, минимум 6 символов
        [
            ['password'],
            'match',
            'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/',
            'message' => 'Пароль должен содержать латинские буквы и цифры (минимум 6 символов)'
        ],

        // длины
        [['fio'], 'string', 'max' => 255],
        [['phone'], 'string', 'max' => 20],
        [['login', 'password'], 'string', 'max' => 100],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'login' => 'Login',
            'password' => 'Password',
            'created_at' => 'Created At',
            'is_admin' => 'Is Admin',
        ];
    }

    /**
     * Gets query for [[BookingFirstClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookingFirstClasses()
    {
        return $this->hasMany(BookingFirstClass::class, ['user_id' => 'id_user']);
    }

    /**
     * Gets query for [[BookingHalls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookingHalls()
    {
        return $this->hasMany(BookingHall::class, ['user_id' => 'id_user']);
    }


  

    public static function findIdentity($id_user)
    {
        return static::findOne($id_user);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByLogin($login)
    {          
        $us = User::findOne(['login'=>$login]);        
        return $us;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id_user;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
       
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
     
    }
  public function validatePassword($password)
{
    return Yii::$app->security->validatePassword(
        $password,
        $this->password
    );
}

}
