<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\TaskSearchForm;
use yii\base\Action;
use Yii;

class IndexAction extends Action
{
    public function run(): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->search(
            Yii::$app->request->queryParams
        );

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}
