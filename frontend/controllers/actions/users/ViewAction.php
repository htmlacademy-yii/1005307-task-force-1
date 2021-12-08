<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use yii\web\HttpException;
use yii\web\View;
use yii\base\Action;

class ViewAction extends Action
{
    public function run($id, View $view)
    {
        $user = Users::find()->andWhere(['id' => $id])->one();

        if (property_exists(new Users(), 'user_role') && !$user || $this->controller->user->id !== $user->id && $user->user_role !== 'doer') {
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
