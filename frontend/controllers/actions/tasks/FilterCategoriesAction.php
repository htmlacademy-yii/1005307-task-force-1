<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\TaskSearchForm;

class FilterCategoriesAction extends BaseAction
{
    public function run($category_id): string
    {
        $searchForm = new TaskSearchForm;
        $dataProvider = $searchForm->searchByCategories($category_id, $this->user);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}
