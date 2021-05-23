<?php

namespace app\models\users;

use yii;
use app\models\opinions\Opinions;

/**
 * This is the ActiveQuery class for [[Users]].
 *
 * @see Users
 */
class UsersQuery extends \yii\db\ActiveQuery
{

    public function withOpinionsFilter(int $min): self
    {
        return $this->andFilterHaving(['>', 'opinions_count', $min]);
    }

    public function isFreeNow(): self
    {
            return $this->andWhere(['tasks.id' => null]);
    }

    public function isOnlineNow(): self
    {
        return $this->andWhere([
            'between',
            'last_activity_time',
            strftime("%F %T", strtotime("-30 min")),
            strftime("%F %T")
        ]);
    }
}
