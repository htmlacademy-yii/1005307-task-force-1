<?php

declare(strict_types=1);

namespace frontend\controllers\actions\myTasks;

use frontend\models\tasks\TaskSearchForm;
use Yii;

class IndexAction extends BaseAction
{
    public function run(): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->searchByStatus(Yii::$app->request->queryParams);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}