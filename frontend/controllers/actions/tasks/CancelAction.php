<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use yii\base\Action;
use yii\base\BaseObject;
use yii\web\Response;

class CancelAction extends Action
{
    public function run(int $taskId): Response
    {
        $task = Tasks::findOne($taskId);
        if (property_exists(new Tasks(), 'status_task')) {
            $task->status_task = 'Отмененное';
            $task->save(false);
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $task->id
        ]);
    }
}
