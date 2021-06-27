<?php

namespace frontend\models\tasks;

class TasksQuery extends \yii\db\ActiveQuery
{

    public function categoriesFilter(array $targetCategories): self
    {
        return $this->andWhere(['category_id' => $targetCategories]);
    }

    public function withoutRepliesFilter(): self
    {
        return $this->andFilterHaving(['=', 'replies_count', '0']);
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

    public function nameSearch($name) {
        return $this->andFilterWhere(['like', 'tasks.name', $name]);
    }
}
