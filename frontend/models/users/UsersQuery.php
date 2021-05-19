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
}
