<?php

declare(strict_types=1);

namespace frontend\controllers\actions\myTasks;

use yii\base\Action;

abstract class BaseAction extends Action
{
    public $user;

    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user)) {
            $this->user = \Yii::$app->user->getIdentity();
        }
    }
}
