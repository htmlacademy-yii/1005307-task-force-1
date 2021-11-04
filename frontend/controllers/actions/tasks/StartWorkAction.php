<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;
use frontend\models\tasks\Tasks;
use frontend\models\notifications\Notifications;
use yii\web\Response;

class StartWorkAction extends BaseAction
{
    public function run(int $doerId, int $taskId): Response
    {
        $task = Tasks::findOne($taskId);
        $task->status_task = 'На исполнении';
        $task->doer_id = $doerId;
        $task->save(false);
        $notification = new Notifications();
        $notification->addNotification(
            $task->id,
            4,
            $task->doer_id,
            'is_subscribed_actions'
        );
        return $this->controller->redirect([
            'tasks/index'
        ]);
    }
}
