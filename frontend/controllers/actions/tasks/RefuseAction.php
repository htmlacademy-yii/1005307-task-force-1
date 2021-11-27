<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\notifications\Notifications;
use frontend\models\tasks\RefuseForm;
use frontend\models\tasks\Tasks;
use Yii;
use yii\base\Action;
use yii\web\Response;

class RefuseAction extends Action
{
    public function run(): Response
    {
        $refuseForm = new RefuseForm();

        if ($refuseForm->load(Yii::$app->request->post())) {
            $task = Tasks::findOne($refuseForm->task_id);
            if (isset($task->status_task)) {
                $task->status_task = 'Провалено';
                $task->save(false);
            }

            $tasks = new Tasks();
            if (isset($this->controller->user->failed_tasks)) {
                $this->controller->user->failed_tasks = $tasks->countUsersTasks($task->status_task, $this->controller->user);
                $this->controller->user->save(false);
            }

            if (isset($task->client_id)) {
                $notification = new Notifications([
                    'notification_category_id' => 3,
                    'setting' => 'is_subscribed_actions',
                    'task_id' => $task->id,
                    'user_id' => $task->client_id,
                    'visible' => 1
                ]);

                $notification->save(false);
                $notification->addNotification();
            }
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
