<?php
declare(strict_types = 1);

namespace frontend\models\account;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $user;
    /**
     * @var mixed
     */

    public function attributeLabels(): array
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ',
        ];
    }

    public function rules(): array
    {
        return [
            [['email', 'password'], 'safe'],
            [['email', 'password'], 'required', 'message' => "Поле «{attribute}» не может быть пустым"],
            [['password'], 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

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
