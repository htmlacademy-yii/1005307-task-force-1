<?php

namespace frontend\models\users;

use frontend\models\categories\Categories;

use yii;

class UserSearchForm extends Users
{
    public $searchedCategories = [];
    public $searchName;
    public $isFreeNow;
    public $isOnlineNow;
    public $hasOpinions;
    public $isFavourite;

    public function rules(): array
    {
        return [
            [['searchedCategories', 'searchName', 'isFreeNow', 'isOnlineNow', 'hasOpinions', 'isFavourite'], 'safe'],
        ];
    }

    public function getCategoriesFilter(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function search($params): UsersQuery
    {
        $query = Users::find();
        $this->load($params);

        if (!$this->validate()) {
            return $query;
        }

        return $query;
    }
}
