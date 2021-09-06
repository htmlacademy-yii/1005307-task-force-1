<?php

declare(strict_types=1);

namespace frontend\controllers\actions\myTasks;

use frontend\models\tasks\TaskSearchForm;
use Yii;

class IndexAction extends BaseAction
{
    public function run($status_task): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->searchByStatus(Yii::$app->request->queryParams, $this->user->id, $this->user->user_role, $status_task);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm,
            'user' => $this->user
        ]);
    }
}
