<?php

declare(strict_types=1);

namespace frontend\controllers\actions\myTasks;

use frontend\models\tasks\TaskSearchForm;
use Yii;
use yii\base\Action;

class IndexAction extends Action
{
    public function run($status_task): string
    {
        $searchForm = new TaskSearchForm;

        if (isset($this->controller->user->user_role)) {
            $dataProvider = $searchForm->searchByStatus(
                Yii::$app->request->queryParams,
                $this->controller->user->id,
                $this->controller->user->user_role,
                $status_task
            );
        }

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm,
            'user' => $this->controller->user,
            'status_task' => $status_task
        ]);
    }
}
