<?php

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\users\UserOptionSettings;
use frontend\models\users\Users;
use frontend\models\notifications\Notifications;
use yii;
use yii\web\Controller;

class EventController extends Controller
{
    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\event\IndexAction::class,
        ];
    }
}
