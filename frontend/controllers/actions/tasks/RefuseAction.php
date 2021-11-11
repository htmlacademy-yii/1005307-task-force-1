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
            $this->controller->user->failed_tasks = Tasks::find()
                ->where(['doer_id' => $this->controller->user->id])
                ->andWhere(['status_task' => 'Провалено'])->count();
            $user_client = Users::findOne($task->client_id);
            $this->controller->user->save(false);

            $notification = new Notifications();
            $notification->addNotification(
                $task->id,
                3,
                $user_client->id,
                'is_subscribed_actions'
            );
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
