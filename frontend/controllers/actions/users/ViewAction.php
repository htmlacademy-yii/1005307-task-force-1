<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use yii\web\NotFoundHttpException;
use yii\base\Action;

class ViewAction extends Action
{
    public function run($id)
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->controller->render('view', ['user' => $user]);
    }
}
