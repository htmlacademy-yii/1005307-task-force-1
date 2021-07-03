<?php

namespace frontend\models\users;

use frontend\models\categories\Categories;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "user_search_form".
 *
 * @property int|null $free_now
 * @property int|null $online_now
 * @property int|null $has_opinions
 * @property int|null $is_favourite
 */

class UserSearchForm extends Model
{
    public $searchedCategories = [];
    public $additionalFilter = [];
    public $periodFilter = [];
    public $searchName;
    public $isFreeNow;
    public $isOnlineNow;
    public $hasOpinions;
    public $isFavourite;
    private $categories;

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

        $query->orFilterWhere([
            'searchedCategories' => $this->searchedCategories,
            'isFreeNowFilter' => $this->isFreeNow,
            'isOnlineNowFilter' => $this->isOnlineNow,
            'hasOpinionsFilter' => $this->hasOpinions,
            'isFavouriteFilter' => $this->isFavourite,
        ]);

        $query->andFilterWhere(['like', 'name', $this->searchName]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
