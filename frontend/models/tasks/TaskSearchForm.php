<?php

namespace app\models\tasks;

use app\models\categories\Categories;
use yii\helpers\ArrayHelper;

class TaskSearchForm extends \yii\db\ActiveRecord {
    public $categoriesFilter = [];
    public $additionalFilter = [];
    public $periodFilter = [];
    public $searchName = null;
    private $categories;

    public function getAdditionalOptions() {
        return [
            'no_replies' => 'Без откликов',
            'online' => 'Удаленная работа'
        ];
    }

    public function getCategoriesFilter(): array
    {
        if (!isset($this->categories)) {
            $this->categories = ArrayHelper::map(Categories::getAll(), 'id', 'name');
        }

        return $this->categories;
    }

    public function getPeriodFilter(): array {
        return [
            'day' => 'за день',
            'week' => 'за неделю',
            'month' => 'за месяц',
            'all' => 'за всё время',
        ];
    }

    public function rules()
    {
        return [
            [['categoriesFilter', 'additionalFilter', 'period_filter', 'searchName', 'no_replies', 'online', 'day', 'week', 'month', 'all'], 'safe']
        ];
    }
}
