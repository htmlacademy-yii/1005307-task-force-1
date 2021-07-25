<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;
use yii\base\Action;

use Yii;

class LogoutAction extends Action
{
    public function run()
    {
        Yii::$app->user->logout();

        return $this->controller->goHome();
    }
}
