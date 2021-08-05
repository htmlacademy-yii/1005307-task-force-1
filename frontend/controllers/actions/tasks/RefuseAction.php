<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;
use frontend\models\tasks\Tasks;
use Yii;

use frontend\models\task_actions\RefuseForm;
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
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
