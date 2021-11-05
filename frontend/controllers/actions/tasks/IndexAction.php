<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\TaskSearchForm;
use Yii;

class IndexAction extends BaseAction
{
    public function run(): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->search(
            Yii::$app->request->queryParams,
            $this->user
        );

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}
