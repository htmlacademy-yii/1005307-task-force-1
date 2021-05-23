<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\tasks\TaskService;
use app\models\tasks\TaskSearchForm;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $request = Yii::$app->request;
        $searchForm = new TaskSearchForm();
        $taskService = new TaskService($request);
        $tasks = $taskService->getTasks($searchForm);
        return $this->render('index', compact('tasks', 'searchForm'));
    }
}
