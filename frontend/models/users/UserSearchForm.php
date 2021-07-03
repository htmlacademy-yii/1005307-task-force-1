<?php

namespace frontend\models\users;

use frontend\models\categories\Categories;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearchForm extends Model
{
    public $searchedCategories = [];
    public $searchName;
    public $isFreeNow;
    public $isOnlineNow;
    public $hasOpinions;
    public $isFavourite;

    public static function tableName(): string
    {
        return 'user_search_form';
    }

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

        $query->andFilterWhere([
            'searchedCategories' => $this->searchedCategories,
            'isFreeNowFilter' => $this->isFreeNow,
            'isOnlineNowFilter' => $this->isOnlineNow,
            'hasOpinionsFilter' => $this->hasOpinions,
            'isFavouriteFilter' => $this->isFavourite,
            'searchName' => $this->searchName
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
