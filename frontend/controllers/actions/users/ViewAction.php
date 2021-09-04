<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use yii\web\NotFoundHttpException;
use yii\base\Action;
use yii\web\View;

class ViewAction extends BaseAction
{
    public function run($id, View $view)
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }
        $view->params['user_id'] = $this->user->id;
        $view->params['user'] = $this->user;

        return $this->controller->render('view', ['user' => $user]);
    }
}
