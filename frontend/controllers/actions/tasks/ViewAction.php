<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\task_actions\TaskActions;
use yii\web\NotFoundHttpException;
use yii\web\View;

class ViewAction extends BaseAction
{
    public function run($id, View $view): string
    {
        $tasks = new Tasks();
        $task = $tasks->getOneTask($id);

        if ($task->status_task !== 'Новое') {
            if ($this->user->id !== $task->client_id && $this->user->id !== $task->doer_id) {
                $this->controller->redirect('/tasks/index');
            }
        }
        $taskActions = new TaskActions($task->client_id, $this->user->id, $task->doer_id);

        if (empty($task)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        $view->params['task_id'] = $id;
        $view->params['task'] = $task;
        $view->params['user_id'] = $this->user->id;
        $view->params['user'] = $this->user;
        $view->params['doer_id'] = $task->doer_id;
        $view->params['client_id'] = $task->client_id;

        return $this->controller->render('view', ['taskActions' => $taskActions, 'task' => $task, 'user' => $this->user]);
    }
}
