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
            $tasks = Tasks::find()->where(['doer_id' => $user_doer->id]);
            $user_doer->failed_tasks = $tasks->andWhere(['status_task' => 'Провалено'])->count();
            $user_doer->save();
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
