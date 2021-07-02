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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        // you can add sorting here

        $this->load($params);

        // you can define your filters here

        return $dataProvider; // this will become your $searchModel
    }
}
