<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

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
        $data = Tasks::getLastTasks();
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
