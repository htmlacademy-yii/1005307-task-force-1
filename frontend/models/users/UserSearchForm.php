<?php

namespace frontend\models\users;

use yii\data\ActiveDataProvider;

class UserSearchForm extends Users
{
    public $hasOpinions;
    public $isFavourite;
    public $isFreeNow;
    public $isOnlineNow;
    public $searchedCategories = [];
    public $searchName;

    public function rules(): array
    {
        return [
            [['hasOpinions', 'isFavourite', 'isFreeNow', 'isOnlineNow', 'searchedCategories', 'searchName'], 'safe'],
        ];
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

        $query->where(['user_role' => 'doer'])
            ->with('userCategories')
            ->with('favourites')
            ->with('portfolioPhotos')
            ->joinWith('optionSet')
            ->andWhere(['is_hidden_account' => 0])
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
            $this->hasOpinions = null;
            $this->isFavourite = null;
            $this->isFreeNow = null;
            $this->isOnlineNow = null;
            $this->searchedCategories = [];
            $query->nameSearch($this->searchName);
        }

        return $dataProvider;
    }
}
