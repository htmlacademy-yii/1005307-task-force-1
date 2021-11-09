<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class TaskSearchForm extends Tasks
{
    public $searchedCategories = [];
    public $noResponses;
    public $online;
    public $periodFilter;
    public $searchName;

    public function rules(): array
    {
        return [
            [['searchedCategories', 'periodFilter', 'searchName', 'noResponses', 'online', 'all'], 'safe'],
        ];
    }

    public function getPeriodFilter(): array
    {
        return [
            'day' => 'за день',
            'week' => 'за неделю',
            'month' => 'за месяц'
        ];
    }

    private function getTasks($query): void
    {
        $query->joinWith('responses')
            ->joinWith('city')
            ->select([
                'tasks.*',
                'count(responses.comment) as responses_count'
            ])
            ->andwhere(['status_task' => 'Новое'])
            ->andWhere(['is', 'expire', null])
            ->orFilterWhere(['>=', 'expire', new Expression('NOW()')])
            ->with('category')
            ->with('city')
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Tasks::find();
        $session = Yii::$app->session;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $this->load($params);

        $this->getTasks($query
            ->andWhere(['city_id' => $session->get('city')])
            ->orWhere(['city_id' => null]));

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->searchedCategories) {
            $query->categoriesFilter($this->searchedCategories);
        }

        if ($this->noResponses) {
            $query->withoutRepliesFilter();
        }

        if ($this->online) {
            $query->onlineFilter();
        }

        if ($this->periodFilter) {
            $query->periodFilter($this->periodFilter);
        }

        if ($this->searchName) {
            $query->nameSearch($this->searchName);
        }

        return $dataProvider;
    }

    public function searchByCategories($category): ActiveDataProvider
    {
        $query = Tasks::find();
        $session = Yii::$app->session;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->getTasks($query
            ->andWhere(['city_id' => $session->get('city')])
            ->orWhere(['city_id' => null]));
        $query->andWhere(['category_id' => $category]);

        return $dataProvider;
    }

    public function searchByStatus($params, $user_id, $user_role, $status_task): ActiveDataProvider
    {
        $query = Tasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        $query->with('category')
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC])->asArray();

        if ($status_task !== 'Просроченное') {
            $query->where(['status_task' => $status_task]);
        }

        if ($status_task == 'На исполнении') {
            $query->andWhere(['is', 'expire', null])
                ->orFilterWhere(['>=', 'expire', new Expression('NOW()')]);
        }

        if ($status_task == 'Просроченное') {
            $query->andWhere(['status_task' => 'На исполнении'])
                ->andFilterWhere(['<', 'expire', new Expression('NOW()')]);
        }

        if ($status_task == 'Отмененное') {
            $query->andWhere(['status_task' => 'Отмененное'])
                ->orWhere(['status_task' => 'Провалено']);
        }

        $user_role == 'client' ?
            $query->andWhere(['client_id' => $user_id])
                ->joinWith('doer') :
            $query->andWhere(['doer_id' => $user_id])
                ->joinWith('client');

        return $dataProvider;
    }
}
