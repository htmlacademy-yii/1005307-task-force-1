<?php

namespace frontend\controllers;

use yii\web\Controller;

class EventController extends Controller
{
    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\event\IndexAction::class,
            'disable' => \frontend\controllers\actions\event\DisableAction::class,
            'add-notification' => \frontend\controllers\actions\event\AddNotificationAction::class
        ];
    }
}
