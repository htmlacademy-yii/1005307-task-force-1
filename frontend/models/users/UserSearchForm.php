<?php

namespace app\models\users;

use Yii;

use app\models\categories\Categories;

/**
 * This is the model class for table "user_search_form".
 *
 * @property int|null $free_now
 * @property int|null $online_now
 * @property int|null $has_opinions
 * @property int|null $is_favourite
 */

class UserSearchForm extends \yii\db\ActiveRecord
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

    public static function tableName()
    {
        return 'user_search_form';
    }

    public function rules()
    {
        return [
            [['searchedCategories', 'searchName', 'isFreeNow', 'isOnlineNow', 'hasOpinions', 'isFavourite'], 'safe'],
        ];
    }

    public function getCategoriesFilter()
    {
        return Categories::getCategoriesFilters();
    }
}
