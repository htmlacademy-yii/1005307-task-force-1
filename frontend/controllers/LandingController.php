<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;

use Yii;
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
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['tasks/']);
        }
        $tasks = Tasks::getLastTasks();
        return $this->render('index', ['tasks' => $tasks]);
    }
}

