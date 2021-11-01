<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii\db\ActiveQuery;

class TasksQuery extends ActiveQuery
{

    public function categoriesFilter(array $targetCategories): self
    {
        return $this->andWhere(['category_id' => $targetCategories]);
    }

    public function withoutRepliesFilter(): self
    {
        return $this->andFilterHaving(['=', 'responses_count', '0']);
    }

    public function onlineFilter(): self
    {
        return $this->andWhere(['city' => null]);
    }

    public function periodFilter($period): self
    {
        if ($period === 'day') {
            return $this->andWhere('tasks.dt_add BETWEEN CURDATE() AND (CURDATE() + 1)');
        }

        if ($period === 'week') {
            return $this->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 7 DAY)');
        }

        if ($period === 'month') {
            return $this->andWhere('tasks.dt_add >= DATE_SUB(NOW(), INTERVAL 30 DAY)');
        }
        return $this;
    }

    public function nameSearch($name): TasksQuery
    {
        return $this->orWhere(['like', 'tasks.name', $name]);
    }
}
