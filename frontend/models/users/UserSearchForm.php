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
    public $categoriesFilter = [];
    public $additionalFilter = [];
    public $periodFilter = [];
    public $searchName;
    public $hasOpinions;
    private $categories;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_search_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoriesFilter', 'additionalFilter', 'search_name', 'free_now', 'online_now', 'has_opinions', 'is_favourite'], 'integer'],
        ];
    }

    public function getCategoriesFilter(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function getAdditionalOptions() : array
    {
        return [
            'free_now' => 'Сейчас свободен',
            'online_now' => 'Сейчас онлайн',
            'has_opinions' => 'Есть отзывы',
            'is_favourite' => 'В избранном'
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserSearchFormQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSearchFormQuery(get_called_class());
    }
}
