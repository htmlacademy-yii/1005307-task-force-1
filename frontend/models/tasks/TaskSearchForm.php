<?php
declare(strict_types = 1);

namespace frontend\models\tasks;

use frontend\models\categories\Categories;

use frontend\models\users\Users;
use yii\base\BaseObject;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearchForm extends Model
{
    public $searchedCategories = [];
    public $noReplies;
    public $online;
    public $periodFilter;
    public $searchName;

    public function rules(): array
    {
        return [
            [['searchedCategories', 'periodFilter', 'searchName', 'noReplies', 'online', 'all'], 'safe'],
        ];
    }

    public function getCategoriesFilter(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function getPeriodFilter(): array
    {
        return [
            'day' => 'за день',
            'week' => 'за неделю',
            'month' => 'за месяц'
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Tasks::find();

        $query->orFilterWhere([
            'searchedCategories' => $this->searchedCategories,
            'noRepliesFilter' => $this->noReplies,
            'onlineFilter' => $this->online,
            'periodFilter' => $this->periodFilter,
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
