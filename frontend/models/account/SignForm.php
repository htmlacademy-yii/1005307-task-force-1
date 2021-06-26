<?php

namespace app\models\account;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\models\cities\Cities;
use app\models\users\Users;

class SignForm extends ActiveRecord
{
    public $city_id;
    public $name;
    public $email;
    public $password;
    private $cities;

    public function getCities(): array
    {
        if (!isset($this->cities)) {
            $this->cities = ArrayHelper::map(Cities::getAll(), 'id', 'city');
        }

        return $this->cities;
    }

    public function rules()
    {
        return [
            [['city_id', 'name', 'email', 'password'], 'required', 'message' => "Поле «{attribute}» не может быть пустым"],
            [['city_id'], 'integer', 'message' => "Выбрано не валидное значение «{value}» поля «{attribute}»"],
            [['password'], 'string', 'min' => 8, 'tooShort' =>  "Длина пароля от 8 символов"],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id'], 'message' => "Выбран несуществующий город"],
            [['email'], 'email', 'message' => 'Введите валидный адрес электронной почты'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'targetClass' => Users::class, 'message' => "Пользователь с еmail «{value}» уже зарегистрирован"],
            [['city_id', 'name', 'email', 'password'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city_id' => 'Город проживания',
            'password' => 'Пароль',
        ];
    }
}
