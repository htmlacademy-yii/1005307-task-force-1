<?php
declare(strict_types=1);

namespace frontend\models\account;

use yii\base\Model;

class LoginForm extends Model
{
    public $err;
    public $email;
    public $password;
    public $user;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required',
                'message' => "Поле «{attribute}» не может быть пустым"],
            [['password'], 'validatePassword'],
            [['err', 'email', 'password'], function () {
                if (!empty($this->errors)) {
                    if (isset($this->email) && $this->email) {
                        $this->addError('err', 'Введите верный логин/пароль');
                    }
                }
            }],
            [['email'], 'trim'],
            [['email', 'password'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ',
        ];
    }

    public function validatePassword($attribute): void
    {
        $user = $this->getUser();

        if (!$this->hasErrors()) {
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    public function getUser(): ?UserIdentity
    {
        if ($this->user === null) {
            $this->user = UserIdentity::findOne(['email' => $this->email]);
        }

        return $this->user;
    }
}
