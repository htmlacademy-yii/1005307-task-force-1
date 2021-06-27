<?php
declare(strict_types = 1);

namespace frontend\models\account;

use Yii;

final class SignHandler
{
    private $signHandler;

    public function login(LoginForm $form): bool
    {
        if ($form->validate()) {
            $user = $form->user;
            Yii::$app->user->login($user);

            return true;
        }

        return false;
    }
}
