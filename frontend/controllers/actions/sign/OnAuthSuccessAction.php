<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\cities\Cities;
use yii\base\Action;

use frontend\models\users\Users;
use yii;

class OnAuthSuccessAction extends Action
{
    public function run($client)
    {
        $attributes = $client->getUserAttributes();

        $user = Users::findOne(['vk_id' => $attributes['id']]);

        if ($user) {
            $user = (Yii::$app->user->userIdentity)::findIdentity($user->id);

            if ($user) {
                Yii::$app->user->login($user);
            }

            return $this->goHome();
        } else {
            if (isset($attributes['email'])) {
                $user = Users::findOne(['email' => $attributes['email']]);

                if ($user) {
                    $user->vk_id = $attributes['id'];

                    if ($user->avatar === null && isset($attributes['photo'])) {
                        $user->avatar = $attributes['photo'];
                    }

                    $user->save();

                    $user = (Yii::$app->user->userIdentity)::findIdentity($user->id);

                    if ($user) {
                        Yii::$app->user->login($user);
                    }

                    return $this->goHome();
                }
            }
            $user = new Users;
            $user->vk_id = $attributes['id'];
            $user->name = $attributes['first_name'] . ' ' . $attributes['last_name'];
            $user->city_id = (Cities::find()->one())->id;

            $user->email = $attributes['email'] ?? null;
            $user->avatar = $attributes['photo'] ?? null;
            $user->password = Yii::$app->security->generateRandomString(6);
            $user->save();

            if ($user) {
                Yii::$app->user->login($user);
            }

            return $this->goHome();
        }
    }
}
