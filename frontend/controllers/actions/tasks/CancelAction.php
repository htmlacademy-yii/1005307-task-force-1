<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use yii\web\Response;

class CancelAction extends BaseAction
{
    public function run(int $taskId): Response
    {
        $task = Tasks::findOne($taskId);
        $task->status_task = 'Отменено';
        $task->save(false);

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
