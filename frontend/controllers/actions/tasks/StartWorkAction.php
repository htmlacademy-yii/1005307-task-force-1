<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\notifications\Notifications;
use frontend\models\tasks\Tasks;
use yii\base\Action;
use yii\web\Response;

class StartWorkAction extends Action
{
    public function run(int $doerId, int $taskId): Response
    {
        $task = Tasks::findOne($taskId);
        $task->status_task = 'На исполнении';
        $task->doer_id = $doerId;
        $task->save(false);

        $notification = new Notifications([
            'notification_category_id' => 4,
            'setting' => 'is_subscribed_actions',
            'task_id' => $task->id,
            'user_id' => $task->doer_id,
            'visible' => 1
        ]);

        $notification->save(false);
        $notification->addNotification();

        return $this->controller->redirect([
            'tasks/index'
        ]);
    }
}
