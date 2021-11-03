<?php
declare(strict_types=1);

namespace frontend\models\users;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TasksQuery;
use yii\db\ActiveQuery;
use yii\redis\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $user_id
 * @property int $failed_tasks
 * @property int $done_tasks
 * @property int $created_tasks
 * @property int $opinions_count
 */
class Counters extends ActiveRecord
{
    const SCENARIO_UPDATE = 'update';

    public function attributes(): array
    {
        return ['user_id', 'failed_tasks', 'done_tasks', 'created_tasks', 'opinions_count'];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getData($status_task, $client, $doer)
    {
        return Tasks::find()->where(['status_task' => $status_task])
            ->andWhere(['client_id' => $client])
            ->andWhere(['doer_id' => $doer])
            ->count();
    }
}
