<?php
declare(strict_types=1);

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class LandingController extends Controller
{
    public $layout = 'anon';

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['tasks/']);
                }
            ]
        ];
    }

    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\landing\IndexAction::class,
        ];
    }


}
