<?php

namespace app\models\tasks;

use app\models\categories\Categories;
use yii\helpers\ArrayHelper;

class TaskSearchForm extends \yii\base\Model
{
    public $searchedCategories = [];
    public $noReplies;
    public $online;
    public $periodFilter = [];
    public $searchName = null;

    public function rules()
    {
        return [
            [['searchedCategories', 'periodFilter', 'searchName', 'noReplies', 'online', 'day', 'week', 'month', 'all'], 'safe'],
        ];
    }

    public function getCategoriesFilter(): array
    {
        if (!isset($categories)) {
            $categories = ArrayHelper::map(Categories::getAll(), 'id', 'name');
        }

        return $categories;
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
