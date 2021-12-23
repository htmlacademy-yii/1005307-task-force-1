<?php
declare(strict_types=1);

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class SignController
 * @package frontend\controllers
 */
class SignController extends Controller
{
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
                        'actions' => ['index', 'login', 'auth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\sign\IndexAction::class,
            'login' => \frontend\controllers\actions\sign\LoginAction::class,
            'logout' => \frontend\controllers\actions\sign\LogoutAction::class,
        ];
    }
}
