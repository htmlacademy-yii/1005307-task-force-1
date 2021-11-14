<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\notifications\Notifications;
use frontend\models\tasks\RefuseForm;
use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use Yii;
use yii\web\Response;
use yii\base\Action;

class RefuseAction extends Action
{
    public function run(): Response
    {
        $refuseForm = new RefuseForm();

        if ($refuseForm->load(Yii::$app->request->post())) {
            $task = Tasks::findOne($refuseForm->task_id);
            $task->status_task = 'Провалено';
            $task->save(false);

            $tasks = new Tasks();
            $this->controller->user->failed_tasks = $tasks->countUsersTasks($task->status_task, $this->controller->user);
            $this->controller->user->save(false);

            $notification = new Notifications([
                'notification_category_id' => 3,
                'task_id' => $task->id,
                'visible' => 1,
                'user_id' => $task->client_id,
                'setting' => 'is_subscribed_actions'
            ]);
            $notification->save(false);
            $notification->addNotification();
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
