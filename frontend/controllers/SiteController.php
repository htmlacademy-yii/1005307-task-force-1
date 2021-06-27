<?php

declare(strict_types=1);

namespace frontend\controllers;
use frontend\models\tasks\Tasks;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{

    public function actionIndex(): string
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(['tasks/']);
        }

        $this->layout = 'anon';
        $tasks = Tasks::getLastTasks();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
