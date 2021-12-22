<?php
declare(strict_types=1);

namespace frontend\models\account;

use yii\base\Model;

/**
 * LoginForm
 */
class LoginForm extends Model
{
    public $err;
    public $email;
    public $password;
    public $user;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required',
                'message' => "Поле «{attribute}» не может быть пустым"],
            [['password'], 'validatePassword'],
            [['err', 'email', 'password'], function () {
                if (!empty($this->errors)) {
                    if ($this->email) {
                        $this->addError('err', 'Введите верный логин/пароль');
                    }
                }
            }],
            [['email'], 'trim'],
            [['email', 'password'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ',
        ];
    }

    /**
     * Validates password
     *
     * @return void
     */
    public function validatePassword($attribute): void
    {
        $this->user = $this->getUser();

        if (!$this->hasErrors()) {
            if (!$this->user || !$this->user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    /**
     * get user
     *
     * @return UserIdentity|null
     */
    public function getUser(): ?UserIdentity
    {
        if ($this->user === null) {
            $this->user = UserIdentity::findOne(['email' => $this->email]);
        }

        return $this->user;
    }
}
