<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\TaskSearchForm;
use frontend\models\users\Users;
use Yii;
use yii\base\Action;
use yii\filters\AccessControl;

class IndexAction extends Action
{
    public function run(): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->searchByFilters(Yii::$app->request->queryParams);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}
