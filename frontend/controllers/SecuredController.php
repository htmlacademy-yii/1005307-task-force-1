<?php

namespace frontend\controllers;

use frontend\models\users\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class SecuredController extends Controller
{
    public $user;

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user)) {
            $user = \Yii::$app->user->getIdentity();
            $this->user = Users::findOne($user->id);
            $this->user->last_activity_time = date('Y-m-d H:i:s');
            $this->user->save(false, ['last_activity_time']);
        }
    }
}
