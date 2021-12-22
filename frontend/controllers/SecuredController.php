<?php

namespace frontend\controllers;

use frontend\models\users\Users;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class SecuredController
 * @package frontend\controllers
 */
abstract class SecuredController extends Controller
{
    public $user;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Get authorised user and chages his last time visit
     *
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user->getIdentity())) {
            $user = \Yii::$app->user->getIdentity();
            $this->user = Users::findOne($user->id);
            if ($this->user) {
                $this->user->last_activity_time = date('Y-m-d H:i:s');
                $this->user->save(false, ['last_activity_time']);
            }
        }
        return $this->user;
    }
}
