<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\tasks\Tasks;
use app\models\tasks\TaskSearchForm;
use yii\web\Request;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $searchForm = new TaskSearchForm();
        $searchForm->load($this->request->post());
        $tasks = Tasks::getNewTasksByFilters($searchForm);
        return $this->render('index', compact('tasks', 'searchForm'));
    }
}
