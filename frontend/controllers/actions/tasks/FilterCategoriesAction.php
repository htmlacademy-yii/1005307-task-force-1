<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\TaskSearchForm;
use yii\base\Action;

class FilterCategoriesAction extends Action
{
    public function run($category_id): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->searchByCategories(
            $category_id
        );

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}
