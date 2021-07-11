<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use frontend\models\categories\Categories;

use yii;

class TaskSearchForm extends Tasks
{
    public $searchedCategories = [];
    public $noReplies;
    public $online;
    public $periodFilter;
    public $searchName;

    public function rules(): array
    {
        return [
            [['searchedCategories', 'periodFilter', 'searchName', 'noReplies', 'online', 'all'], 'safe'],
        ];
    }

    public function getCategoriesFilter(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function getPeriodFilter(): array
    {
        return [
            'day' => 'за день',
            'week' => 'за неделю',
            'month' => 'за месяц'
        ];
    }

    public function search($params): TasksQuery
    {
        $query = Tasks::getNewTasksByFilters($this);
        $this->load($params);

        if (!$this->validate()) {
            return $query;
        }
        if ($this->load(Yii::$app->request->post())) {
            $this->refresh();
        }

        return $query;
    }
}
