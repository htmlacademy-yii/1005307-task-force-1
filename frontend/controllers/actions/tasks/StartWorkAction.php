<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;
use frontend\models\tasks\Tasks;
use yii\web\Response;
use Yii;

class StartWorkAction extends BaseAction
{
    public function run(int $doerId, int $taskId): Response
    {
        $task = Tasks::findOne($taskId);
        $task->status_task = 'На исполнении';
        $task->doer_id = $doerId;
        $task->save(false);
        Yii::$app->runAction('event/add-notification', ['task_id' => $task->id, 'notification_category' => 4, 'user_id' => $task->doer_id, 'settings' => 'is_subscribed_actions']);
        return $this->controller->redirect([
            'tasks/index'
        ]);
    }
}
