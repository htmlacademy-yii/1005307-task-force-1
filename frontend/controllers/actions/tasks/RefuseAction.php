<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use Yii;

use frontend\models\tasks\RefuseForm;
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
            $user_doer->save(false);
            Yii::$app->runAction('event/add-notification', ['task_id' => $task->id, 'notification_category' => 3, 'user_id' => $task->client_id]);
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
