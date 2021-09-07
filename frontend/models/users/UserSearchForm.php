<?php

namespace frontend\models\users;

use frontend\models\categories\Categories;

use yii;
use yii\data\ActiveDataProvider;

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

    public function search($params): ActiveDataProvider
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith('opinions')
            ->select([
                'users.*',
                'count(opinions.rate) as finished_task_count',
                'count(opinions.description) as opinions_count',
            ])
            ->where(['user_role' => 'doer'])
            ->with('userCategories')
            ->with('favourites')
            ->with('portfolioPhotos')
            ->groupBy('users.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray();

        if ($this->searchedCategories) {
            $query->categoriesFilter($this->searchedCategories);
        }

        if ($this->isFreeNow) {
            $query->isFreeNowFilter();
        }

        if ($this->isOnlineNow) {
            $query->isOnlineNowFilter();
        }

        if ($this->hasOpinions) {
            $query->withOpinionsFilter(0);
        }

        if ($this->isFavourite) {
            $query->isFavouriteFilter();
        }

        if ($this->searchName) {
            $query->nameSearch($this->searchName);
        }

        return $dataProvider;
    }
}
