<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $tasks = Tasks::getNewTasksByDate();
        return $this->render('index', compact('tasks'));
    }
}
