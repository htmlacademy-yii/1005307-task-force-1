<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Favourites;
use frontend\models\users\Users;
use yii\web\NotFoundHttpException;
use yii\base\Action;

class AddFavouriteAction extends Action
{
    public $favourite;

    public function run($isFavouriteValue, $id)
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        if (!$isFavouriteValue) {
            $this->favourite = new Favourites([
                'favourite_person_id' => $user->id,
                'user_id' => $this->controller->user->id
            ]);
            $this->favourite->save();
        }

        if ($isFavouriteValue) {
            $this->favourite = Favourites::find()
                ->where(['user_id' => $this->controller->user->id])
                ->andWhere(['favourite_person_id' => $user->id])
                ->all();

            foreach ($this->favourite as $favourites) {
                $favourites->delete();
            }
        }

        return $this->controller->redirect([
            'users/view',
            'id' => $user->id
        ]);
    }
}
