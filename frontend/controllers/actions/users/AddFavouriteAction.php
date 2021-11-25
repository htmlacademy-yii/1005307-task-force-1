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
        if (!$isFavouriteValue) {
            $this->favourite = new Favourites([
                'favourite_person_id' => $id,
                'user_id' => $this->controller->user->id
            ]);
            $this->favourite->save();
        }

        if ($isFavouriteValue) {
            $this->favourite = Favourites::find()
                ->where(['user_id' => $this->controller->user->id])
                ->andWhere(['favourite_person_id' => $id])
                ->one();
                $this->favourite->delete();
          }

        return $this->controller->redirect([
            'users/view',
            'id' => $id
        ]);
    }
}
