<?php

namespace app\models\tasks;

use app\models\categories\Categories;
use yii\helpers\ArrayHelper;

class TaskSearchForm extends \yii\db\ActiveRecord
{
    public $categoriesFilter = [];
    public $noReplies;
    public $online;
    public $periodFilter = [];
    public $searchName = null;

    public function rules()
    {
        return [
            [['searchName', 'noReplies', 'online', 'day', 'week', 'month', 'all'], 'safe'],
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
