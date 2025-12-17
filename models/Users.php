<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id_user
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $login
 * @property string $password
 * @property string $avatar
 * @property string $role
 * @property string $created_at
 *
 * @property Bookings[] $bookings
 */
class Users extends ActiveRecord implements IdentityInterface
{

    /**
     * ENUM field values
     */
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'login', 'password'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'match', 'pattern' => '/^[а-яА-ЯёЁa-zA-Z\s]+$/u', 'message' => 'Только кириллица и латиница'],
            [['phone'], 'string', 'min' => 10, 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+?[0-9]{10,}$/', 'message' => 'Минимум 10 цифр, символ + разрешён'],
            [['phone'], 'unique'],
            [['login'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['password'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Только латиница и цифры'],
            [['password'], 'string', 'min' => 6],
            [['role'], 'in', 'range' => ['user', 'admin']],
            [['role'], 'default', 'value' => self::ROLE_USER],
            [['avatar'], 'string', 'max' => 255],
            [['avatar'], 'default', 'value' => ''],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        // убираем небезопасные поля
        unset($fields['password']);
        return $fields;
    }

    public static function primaryKey()
    {
        return ['id_user'];
    }

    /**
     * IdentityInterface methods for JWT
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // JWT токен будет проверяться через HttpBearerAuth
        return null;
    }

    public function getId()
    {
        return $this->id_user;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Хеширование пароля перед сохранением
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Хешируем пароль только если он был изменен (не является уже хешем)
            if (!empty($this->password) && !$this->isPasswordHash($this->password)) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    /**
     * Проверка, является ли строка хешем пароля
     */
    private function isPasswordHash($password)
    {
        // Yii2 хеши начинаются с $2y$ или $2a$ (bcrypt)
        return preg_match('/^\$2[ay]\$\d{2}\$/', $password) === 1;
    }

    /**
     * Validates password
     */
    public function validatePassword($password)
    {
        // Если пароль в БД не хеширован (старые данные), сравниваем напрямую
        if (!$this->isPasswordHash($this->password)) {
            return $this->password === $password;
        }
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Finds user by login
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'login' => 'Login',
            'password' => 'Password',
            'avatar' => 'Avatar',
            'role' => 'Role',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Bookings::class, ['user_id' => 'id_user']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_USER => 'user',
            self::ROLE_ADMIN => 'admin',
        ];
    }

    /**
     * @return string
     */
    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    /**
     * @return bool
     */
    public function isRoleUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function setRoleToUser()
    {
        $this->role = self::ROLE_USER;
    }

    /**
     * @return bool
     */
    public function isRoleAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setRoleToAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }
}
