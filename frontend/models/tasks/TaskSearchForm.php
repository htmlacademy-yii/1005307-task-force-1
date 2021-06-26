<?php

namespace app\models\tasks;

use app\models\categories\Categories;
use yii\base\Model;

class TaskSearchForm extends Model
{
    public $searchedCategories = [];
    public $noReplies;
    public $online;
    public $periodFilter;
    public $searchName;

    public function rules()
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
}
