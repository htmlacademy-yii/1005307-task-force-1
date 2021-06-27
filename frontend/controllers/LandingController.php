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

    public function behaviors()
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
                'denyCallback' => function($rule, $action) {
                    return $this->goHome();
                },
            ]
        ];
    }

    public function actionIndex(): string
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(['tasks/']);
        }
        $tasks = Tasks::getLastTasks();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
// ptreutel@fahey.com
// 8DB+459&M%%8vL7p
