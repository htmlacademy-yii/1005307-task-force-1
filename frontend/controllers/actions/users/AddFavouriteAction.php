<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use frontend\models\users\Favourites;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;
use yii\base\Action;
use yii\web\View;

class AddFavouriteAction extends BaseAction
{
    public $favourite;
    public function run($isFavouriteValue, $id)
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        if (!$isFavouriteValue) {
            $this->favourite = new Favourites;
            $this->favourite->favourite_person_id = $user->id;
            $this->favourite->user_id = $this->user->id;
            $this->favourite->save();
        }

        if ($isFavouriteValue) {
            $favourite = Favourites::findOne($id);
       //     var_dump($this->favourite);
            $favourite->delete();
        }

        return $this->controller->redirect([
            'users/view',
            'id' => $user->id
        ]);
    }
}
