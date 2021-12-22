<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Class EventController
 * @package frontend\controllers
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\event\IndexAction::class,
        ];
    }
}
