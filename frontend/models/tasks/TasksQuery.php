<?php

namespace app\models\tasks;

/**
 * This is the ActiveQuery class for [[Tasks]].
 *
 * @see Tasks
 */
class TasksQuery extends \yii\db\ActiveQuery
{

    public function withoutRepliesFilter(): self
    {
        return $this->andFilterHaving(['=', 'replies_count', '0']);
    }

    public function onlineFilter(): self
    {
        return $this->andWhere(['city' => null]);
    }

    public function periodFilter(): self
    {
        return $this->andWhere([
            'between',
            'tasks.dt_add',
          //  strftime("%F %T", strtotime("-1 week")),
            //         strftime("%F %T", strtotime("-1 week")),
            strftime("%F %T", strtotime("-1 month")),
            strftime("%F %T")
        ]);
    }
}
