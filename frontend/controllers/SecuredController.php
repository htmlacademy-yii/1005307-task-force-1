<?php

namespace frontend\controllers;

use frontend\models\users\Users;
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
        }
    }
}
