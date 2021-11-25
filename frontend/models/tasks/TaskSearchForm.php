<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

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

    public function getLastTasks(): array
    {
        $query = Tasks::find();
        $this->getTasks($query);
        $query->limit(4);

        return $query->all();
    }

    public function searchByFilters($params): ActiveDataProvider
    {
        $query = (new Query());
        $this->getTasksByCity($query);
        $this->getTasks($query);
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->searchedCategories) {
            $query->andWhere(['category_id' => $this->searchedCategories]);
        }

        if ($this->noResponses) {
            $query->andFilterHaving(['=', 'responses_count', '0']);
        }

        if ($this->online) {
            $query->andWhere(['online' => 1]);
        }

        if ($this->periodFilter) {
            if ($this->periodFilter === 'day') {
                $query->andWhere('tasks.dt_add BETWEEN CURDATE() AND (CURDATE() + 1)');
            }

            if ($this->periodFilter === 'week') {
                $query->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 7 DAY)');
            }

            if ($this->periodFilter === 'month') {
                $query->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 30 DAY)');
            }
        }

        if ($this->searchName) {
            $query->andWhere(['like', 'tasks.name', $this->searchName]);
        }

        return $dataProvider;
    }

    public function searchByCategories($category): ActiveDataProvider
    {
        $query = (new Query());
        $this->getTasksByCity($query);
        $this->getTasks($query);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

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

    private function getTasks($query): void
    {
        $query->andWhere(['status_task' => 'Новое'])
            ->select(
                'tasks.*,
                categories.id as cat_id,
                categories.name as cat_name,
                categories.icon as cat_icon'
            )
            ->from('tasks')
            ->leftJoin('categories', 'tasks.category_id = categories.id')
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC]);
    }

    private function getTasksByCity($query): void
    {
        $session = Yii::$app->session;
        $query
            ->andWhere(['city_id' => $session->get('city')])
            ->orFilterWhere(['online' => 1]);
    }
}
