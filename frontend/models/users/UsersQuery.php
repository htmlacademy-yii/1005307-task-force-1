<?php

namespace app\models\users;

use yii;

class UsersQuery extends \yii\db\ActiveQuery
{

    public function categoriesFilter($targetSpecializations): self
    {
        return $this->joinWith('userCategories')->andFilterWhere(['category_id' => $targetSpecializations]);
    }

    public function withOpinionsFilter(int $min): self
    {
        return $this->andFilterHaving(['>', 'opinions_count', $min]);
    }

    public function isFreeNowFilter(): self
    {
        return $this->joinWith('tasks')->andWhere(['!=','status_task', 'work']);//->orWhere((['status_task' => null]));
    }

    public function isFavouriteFilter(): self
    {
        return $this->joinWith('favourites');
    }

    public function isOnlineNowFilter(): self
    {
        return $this->andWhere([
            'between',
            'last_activity_time',
            strftime("%F %T", strtotime("-30 min")),
            strftime("%F %T")
        ]);
    }

    public function nameSearch($name) {
        return $this->andFilterWhere(['like', 'users.name', $name]);
    }
}
