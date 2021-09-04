<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use frontend\models\users\Favourites;
use yii\web\NotFoundHttpException;
use yii\base\Action;
use yii\web\View;

class AddFavouriteAction extends BaseAction
{
    public function run($isFavouriteValue, $id)
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        if (!$isFavouriteValue) {
            $favourite = new Favourites;
            $favourite->favourite_person_id = $user->id;
            $favourite->user_id = $this->user->id;
            $favourite->save();
        }

        return $this->controller->redirect([
            'users/view',
            'id' => $user->id
        ]);
    }
}
