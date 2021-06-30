<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;

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

    public function actionIndex(): string
    {
        $tasks = Tasks::getLastTasks();
        return $this->render('index', ['tasks' => $tasks]);
    }
}

