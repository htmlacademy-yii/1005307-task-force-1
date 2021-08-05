<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;
use frontend\models\tasks\Tasks;

use frontend\models\responses\Responses;
use yii\web\Response;

class StartWorkAction extends BaseAction
{
    public function run(int $doerId, int $taskId): Response
    {
        $task = Tasks::findOne($taskId);
        $task->status_task = 'На исполнении';
        $task->doer_id = $doerId;
        $task->save(false);

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
