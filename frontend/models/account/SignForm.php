<?php
declare(strict_types=1);

namespace frontend\models\account;

use frontend\models\{cities\Cities, users\Users};
use yii\base\Model;

/**
 * Class SignForm
 * @package frontend\models\account
 */
class SignForm extends Model
{
    public $city_id;
    public $email;
    public $name;
    public $password;
    public $user_role;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_role'], 'required'],
            [['city_id', 'email', 'name', 'password'], 'required',
                'message' => "Поле «{attribute}» не может быть пустым"],
            [['email', 'name'], 'trim'],
            [['city_id'], 'integer',
                'message' => "Выбрано не валидное значение «{value}» поля «{attribute}»"],
            [['password'], 'string',
                'min' => 8,
                'message' => "Длина пароля от 8 символов"],
            [['email'], 'email',
                'message' => 'Введите валидный адрес электронной почты'],
            [['email'], 'unique',
                'targetAttribute' => 'email',
                'targetClass' => Users::class,
                'message' => "Пользователь с еmail «{value}» уже зарегистрирован"],
            [['city_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Cities::class,
                'targetAttribute' => ['city_id' => 'id'],
                'message' => "Выбран несуществующий город"],
            [['city_id', 'email', 'name', 'password', 'user_role'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'city_id' => 'Город проживания',
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'password' => 'Пароль',
        ];
    }
}
