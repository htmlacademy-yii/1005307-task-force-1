<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\task_actions\TaskActions;
use yii\web\NotFoundHttpException;

class ViewAction extends BaseAction
{
    public function run($id)
    {
        $task = Tasks::getOneTask($id);

        if ($task['status_task'] !== 'new') {
            if ($this->user['id'] !== $task['client_id'] && $this->user['id'] !== $task['doer_id']) {
                $this->controller->redirect('/tasks/index');
            }
        }
        $taskActions = new TaskActions($task['client_id'], $this->user['id'], $task['status_task'], $task['doer_id']);

        if (empty($task)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        return $this->controller->render('view', ['task' => $task, 'user' => $this->user, 'taskActions' => $taskActions]);
    }
}
