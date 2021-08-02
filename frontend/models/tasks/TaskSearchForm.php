<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use frontend\models\categories\Categories;

class TaskSearchForm extends Tasks
{
    public $searchedCategories = [];
    public $noResponses;
    public $online;
    public $periodFilter;
    public $searchName;

    public function rules(): array
    {
        return [
            [['searchedCategories', 'periodFilter', 'searchName', 'noResponses', 'online', 'all'], 'safe'],
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
        $query = Tasks::find();
        $this->load($params);

        if (!$this->validate()) {
            return $query;
        }

        return $query;
    }
}
