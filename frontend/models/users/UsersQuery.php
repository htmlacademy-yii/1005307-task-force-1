<?php
declare(strict_types = 1);

namespace frontend\models\users;

use frontend\models\{
    tasks\Tasks
};

use yii;

class UsersQuery extends \yii\db\ActiveQuery
{

    public function categoriesFilter($targetSpecializations): self
    {
        $subQuery = UserCategory::find()
            ->select(['user_id'])
            ->andFilterWhere(['category_id' => $targetSpecializations]);

        return $this->where(['users.id' => $subQuery]);
    }

    public function withOpinionsFilter(int $min): self
    {
        return $this->andFilterHaving(['>', 'opinions_count', $min]);
    }

    public function isFreeNowFilter(): self
    {
        $subQuery = Tasks::find()
            ->select(['doer_id'])
            ->andFilterWhere(['=', 'status_task', 'work']);

        return $this->andFilterWhere(['not', ['users.id' => $subQuery]]);
    }

    public function isFavouriteFilter(): self
    {
        $subQuery = Favourites::find()
            ->select(['favourite_person_id']);
        return $this->where(['users.id' => $subQuery]);
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

    public function nameSearch($name)
    {
        return $this->andFilterWhere(['like', 'users.name', $name]);
    }
}
