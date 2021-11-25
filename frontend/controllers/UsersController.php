<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\users\Users;
use Yii;

class UsersController extends SecuredController
{
    public function init()
    {
        parent::init();

        if (!Yii::$app->user->isGuest) {
            $user = Users::findOne(Yii::$app->user->id);
            $user->last_activity_time = date('Y-m-d H:i:s');
            $user->save(false, ["last_activity_time"]);
        }
    }

    public function actions(): array
    {
        return [
            'add-favourite' => \frontend\controllers\actions\users\AddFavouriteAction::class,
            'index' => \frontend\controllers\actions\users\IndexAction::class,
            'view' => \frontend\controllers\actions\users\ViewAction::class,
        ];
    }
}
