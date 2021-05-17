<?php

namespace app\models\tasks;

use app\models\categories\Categories;
use yii\helpers\ArrayHelper;

class TaskSearchForm extends \yii\db\ActiveRecord
{
    public $categoriesFilter = [];
    public $additionalFilter = [];
    public $periodFilter = [];
    public $searchName = null;

    public function getCategoriesFilter(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function getAdditionalOptions(): array
    {
        return [
            'no_replies' => 'Без откликов',
            'online' => 'Удаленная работа'
        ];
    }

    public function getPeriodFilter(): array
    {
        return [
            'day' => 'за день',
            'week' => 'за неделю',
            'month' => 'за месяц'
        ];
    }

    public function rules()
    {
        return [
            [['categoriesFilter', 'additionalFilter', 'period_filter', 'searchName', 'no_replies', 'online', 'day', 'week', 'month', 'all'], 'safe']
        ];
    }
}
