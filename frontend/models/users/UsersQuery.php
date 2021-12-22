<?php
declare(strict_types=1);

namespace frontend\models\users;

use frontend\models\tasks\Tasks;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Users]].
 *
 * @see Users
 */
class UsersQuery extends ActiveQuery
{
    /**
     * Gets users by categories
     *
     * @param $targetSpecializations
     * @return $this
     */
    public function categoriesFilter($targetSpecializations): self
    {
        $subQuery = UserCategory::find()
            ->select(['user_id'])
            ->andFilterWhere(['category_id' => $targetSpecializations]);

        return $this->where(['users.id' => $subQuery]);
    }

    /**
     * Gets users by opinions
     *
     * @param int $min
     * @return $this
     */
    public function withOpinionsFilter(int $min): self
    {
        return $this->andFilterHaving(['>', 'opinions_count', $min]);
    }

    /**
     * Gets users if they have tasks in execution
     *
     * @return $this
     */
    public function isFreeNowFilter(): self
    {
        $subQuery = Tasks::find()
            ->select(['doer_id'])
            ->andFilterWhere(['=', 'status_task', 'На исполнении']);

        return $this->andWhere(['not', ['users.id' => $subQuery]]);
    }

    /**
     * Gets users if they are added to other users
     *
     * @return $this
     */
    public function isFavouriteFilter(): self
    {
        $subQuery = Favourites::find()
            ->select(['favourite_person_id']);

        return $this->andWhere(['users.id' => $subQuery]);
    }

    /**
     * Gets users if they are online now
     *
     * @return $this
     */
    public function isOnlineNowFilter(): self
    {
        return $this->andWhere([
            'between',
            'last_activity_time',
            strftime("%F %T", strtotime("-30 min")),
            strftime("%F %T")
        ]);
    }

    /**
     * Gets users by name
     *
     * @param $name
     * @return $this
     */
    public function nameSearch($name): self
    {
        return $this->andFilterWhere(['like', 'users.name', $name]);
    }
}
