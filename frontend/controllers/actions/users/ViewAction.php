<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use yii\web\HttpException;
use yii\web\View;

class ViewAction extends BaseAction
{
    public function run($id, View $view)
    {
        $user = Users::find()->andWhere(['id' => $id])->one();

        if (!$user || $this->user->id !== $user->id && $user->user_role !== 'doer') {
            throw new HttpException(
                404,
                'Страницы этого исполнителя не найдено'
            );
        }

        $view->params['user_id'] = $this->user->id;
        $view->params['user'] = $this->user;

        return $this->controller->render('view', ['user' => $user]);
    }
}
