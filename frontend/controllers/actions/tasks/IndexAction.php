<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskSearchForm;
use yii\data\ActiveDataProvider;
use yii\base\Action;
use Yii;

class IndexAction extends Action
{
    public function run()
    {
        $searchForm = new TaskSearchForm();
        $searchForm->search(Yii::$app->request->queryParams);

        $dataProvider = new ActiveDataProvider([
            'query' => Tasks::getNewTasksByFilters($searchForm),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}
