<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;
use frontend\models\notifications\Notifications;
use frontend\models\users\UserOptionSettings;

use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use Yii;

use frontend\models\tasks\RefuseForm;
use yii\base\BaseObject;
use yii\web\Response;

class RefuseAction extends BaseAction
{
    public function run(): Response
    {
        $refuseForm = new RefuseForm();

        if ($refuseForm->load(Yii::$app->request->post())) {
            $task = Tasks::findOne($refuseForm->task_id);
            $task->status_task = 'Провалено';
            $task->save(false);
            $user_doer = Users::findOne($this->user->id);
            $user_doer->failed_tasks = Tasks::find()
                ->where(['doer_id' => $this->user->id])
                ->andWhere(['status_task' => 'Провалено'])->count();
            $user_client = Users::findOne($task->client_id);
            $user_doer->save(false);
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
