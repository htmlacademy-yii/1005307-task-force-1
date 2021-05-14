<?php

namespace app\models\users;

use app\models\categories\Categories;
use yii\helpers\ArrayHelper;

class UserSearchForm extends \yii\db\ActiveRecord
{
    public $categoriesFilter = [];
    public $additionalFilter = [];
    public $periodFilter = [];
    public $searchName = null;
    private $categories;

    public function getCategoriesFilter(): array
    {
        if (!isset($this->categories)) {
            $this->categories = ArrayHelper::map(Categories::getAll(), 'id', 'name');
        }

        return $this->categories;
    }

    public function getAdditionalOptions(): array
    {
        return [
            'free_now' => 'Сейчас свободен',
            'online_now' => 'Сейчас онлайн',
            'has_opinions' => 'Есть отзывы',
            'is_favourite' => 'В избранном'
        ];
    }

    public function rules()
    {
        return [
            [['categoriesFilter', 'additionalFilter', 'period_filter', 'searchName', 'free_now', 'online_now', 'has_opinions', 'is_favourite'], 'safe']
        ];
    }
}
