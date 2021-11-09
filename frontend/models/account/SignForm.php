<?php
declare(strict_types=1);

namespace frontend\models\account;

use frontend\models\{cities\Cities, users\Users};
use yii\base\Model;

class SignForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $city_id;
    public $user_role;

    public function rules(): array
    {
        return [
            [['city_id', 'name', 'email', 'password', 'user_role'], 'required',
                'message' => "Поле «{attribute}» не может быть пустым"],
            [['email', 'name'], 'trim'],
            [['city_id'], 'integer',
                'message' => "Выбрано не валидное значение «{value}» поля «{attribute}»"],
            [['password'], 'string',
                'min' => 8,
                'message' => "Длина пароля от 8 символов"],
            [['city_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Cities::class,
                'targetAttribute' => ['city_id' => 'id'],
                'message' => "Выбран несуществующий город"],
            [['email'], 'email',
                'message' => 'Введите валидный адрес электронной почты'],
            [['email'], 'unique',
                'targetAttribute' => 'email',
                'targetClass' => Users::class,
                'message' => "Пользователь с еmail «{value}» уже зарегистрирован"],
            [['city_id', 'name', 'email', 'password', 'user_role'], 'safe']
        ];
    }

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
