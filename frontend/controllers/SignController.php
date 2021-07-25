<?php
declare(strict_types=1);

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class SignController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if ($action->actionMethod === 'actionLogout') {
                        return $this->redirect(['landing/index']);
                    } else {
                        return $this->goHome();
                    }
                }
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\sign\IndexAction::class,
            'login' => \frontend\controllers\actions\sign\LoginAction::class,
            'logout' => \frontend\controllers\actions\sign\LogoutAction::class,
        ];
    }
}
