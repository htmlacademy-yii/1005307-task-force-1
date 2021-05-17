<?php

namespace app\models\users;

use app\models\categories\Categories;

class UserSearchForm extends \yii\db\ActiveRecord
{
    public $categoriesFilter = [];
    public $additionalFilter = [];
    public $periodFilter = [];
    public $searchName = null;
    private $categories;

    public function getCategoriesFilter(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function getAdditionalOptions(): array
    {
        return [
            $isOnline => 'Сейчас свободен',
          //  'isOnline' => 'Сейчас онлайн',
          //  'hasOpinions' => 'Есть отзывы',
         //   'isFavourite' => 'В избранном'
        ];
    }

    public function rules()
    {
        return [
            [['categoriesFilter', 'additionalFilter', 'searchName', 'freeNow', 'isOnline', 'hasOpinions', 'is_favourite'], 'safe']
        ];
    }
}
