<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use yii\base\Action;
use yii\web\HttpException;
use yii\web\View;

class ViewAction extends Action
{
    public function run($id, View $view)
    {
        $user = Users::find()->andWhere(['id' => $id])->one();
        $users = new Users();
        $tasks = $users->getClientOfActiveTask($this->controller->user->id, $id);

        if (property_exists(new Users(), 'user_role') && !$user || $this->controller->user->id !== $user->id && $user->user_role !== 'doer' && !$tasks) {
            throw new HttpException(
                404,
                'Страницы этого исполнителя не найдено'
            );
        }

        $view->params['user_id'] = $this->controller->user->id;
        $view->params['user'] = $this->controller->user;

        return $this->controller->render('view', ['user' => $user]);
    }
}
