<?php

namespace frontend\models\users;

use yii\data\ActiveDataProvider;

/**
 * Class UserSearchForm
 * @package frontend\models\users
 */
class UserSearchForm extends Users
{
    public $hasOpinions;
    public $isFavourite;
    public $isFreeNow;
    public $isOnlineNow;
    public $searchedCategories = [];
    public $searchName;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['hasOpinions', 'isFavourite', 'isFreeNow', 'isOnlineNow', 'searchedCategories', 'searchName'], 'safe'],
        ];
    }

    /**
     * Searches users by categories, online now, name etc.
     *
     * @param $params
     * @return ActiveDataProvider
     */
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

        $query->with('userCategories')
            ->with('favourites')
            ->with('portfolioPhotos')
            ->joinWith('optionSet')
            ->groupBy('users.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray();

        if ($this->searchName) {
            $this->hasOpinions = null;
            $this->isFavourite = null;
            $this->isFreeNow = null;
            $this->isOnlineNow = null;
            $this->searchedCategories = [];
            $query->andFilterWhere(['like', 'name', $this->searchName]);
        }

        if(!$this->searchName) {
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
        }

        $query->andWhere(['is_hidden_account' => 0])
            ->andWhere(['user_role' => 'doer']);

        return $dataProvider;
    }
}
