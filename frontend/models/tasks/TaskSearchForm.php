<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class TaskSearchForm
 * @package frontend\models\tasks
 */
class TaskSearchForm extends Tasks
{
    public $dataProvider;
    public $noResponses;
    public $online;
    public $periodFilter;
    public $searchedCategories = [];
    public $searchName;
    private $query;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['searchedCategories', 'periodFilter', 'searchName', 'noResponses', 'online', 'all'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPeriodFilter(): array
    {
        return [
            'day' => 'за день',
            'week' => 'за неделю',
            'month' => 'за месяц'
        ];
    }

    /**
     * Get 4 last tasks for landing page
     *
     * @param $params
     * @return array
     */
    public function getLastTasks($params): array
    {
        $this->query = Tasks::find();
        $this->getTasks($params);
        $this->query->limit(4);

        return $this->query->all();
    }

    /**
     * Search all new tasks in session city and filters by categories, no responses,etc
     *
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchByFilters($params): ActiveDataProvider
    {
        $this->query = (new Query());
        $this->getTasksByCity();
        $this->getTasks($params);
        $this->getDataProvider();

        if (!$this->validate()) {
            return $this->dataProvider;
        }

        if ($this->searchedCategories) {
            $this->query->andWhere(['category_id' => $this->searchedCategories]);
        }

        if ($this->noResponses) {
            $this->query->andFilterHaving(['=', 'responses_count', '0']);
        }

        if ($this->online) {
            $this->query->andWhere(['online' => 1]);
        }

        if ($this->periodFilter) {
            if ($this->periodFilter === 'day') {
                $this->query->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 1 DAY)');
            }

            if ($this->periodFilter === 'week') {
                $this->query->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 7 DAY)');
            }

            if ($this->periodFilter === 'month') {
                $this->query->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 30 DAY)');
            }
        }

        if ($this->searchName) {
            $this->query->andWhere(['like', 'tasks.name', $this->searchName]);
        }

        return $this->dataProvider;
    }

    /**
     * Search all new tasks in session city and filters by categories
     *
     * @param $params
     * @param $category
     * @return ActiveDataProvider
     */
    public function searchByCategories($params, $category): ActiveDataProvider
    {
        $this->query = (new Query());
        $this->getTasksByCity();
        $this->getTasks($params);
        $this->getDataProvider();
        $this->searchedCategories = [$category];

        $this->query->andWhere(['category_id' => $category]);

        return $this->dataProvider;
    }

    /**
     * Gets user's tasks and filters by status
     *
     * @param $params
     * @param $user_id
     * @param $user_role
     * @param $status_task
     * @return ActiveDataProvider
     */
    public function searchByStatus($params, $user_id, $user_role, $status_task): ActiveDataProvider
    {
        $this->query = Tasks::find();
        $this->getDataProvider();
        $this->getTasks($params);

        $this->query->with('category')
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC])->asArray();

        if ($status_task == 'Новое' || $status_task == 'Выполнено') {
            $this->query->where(['status_task' => $status_task]);
        }

        if ($status_task == 'На исполнении') {
            $this->query->orWhere(['expire' => null])
                ->orWhere(['>=', 'expire', new Expression('NOW()')])
                ->andWhere(['status_task' => 'На исполнении']);
        }

        if ($status_task == 'Просроченное') {
            $this->query->where(['status_task' => 'На исполнении'])
                ->andFilterWhere(['<', 'expire', new Expression('NOW()')]);
        }

        if ($status_task == 'Отмененное') {
            $this->query->where(['status_task' => 'Отмененное'])
                ->orFilterWhere(['status_task' => 'Провалено']);
        }

        $user_role === 'client' ?
            $this->query->andFilterWhere(['client_id' => $user_id])
                ->joinWith('doer') :
            $this->query->andFilterWhere(['doer_id' => $user_id])
                ->joinWith('client');

        return $this->dataProvider;
    }

    /**
     * Gets all tasks, joins with other models, groups and order
     * @param $params
     */
    private function getTasks($params): void
    {
        $this->load($params);
        $this->query->andWhere(['status_task' => 'Новое'])
            ->select(
                'tasks.*,
                categories.id as cat_id,
                categories.name as cat_name,
                categories.icon as cat_icon,
                cities.city as city'
            )
            ->from('tasks')
            ->leftJoin('categories', 'tasks.category_id = categories.id')
            ->leftJoin('cities', 'tasks.city_id = cities.id')
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC]);
    }

    /**
     * Gets all tasks by session city
     */
    private function getTasksByCity(): void
    {
        $session = Yii::$app->session;
        $this->query
            ->andWhere(['city_id' => $session->get('city')])
            ->orWhere(['online' => 1]);
    }

    /**
     * Gets data provider for list view & pagination
     */
    private function getDataProvider(): void
    {
        $this->dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
    }
}
