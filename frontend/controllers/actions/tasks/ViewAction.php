<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\TaskActions;
use frontend\models\tasks\Tasks;
use yii\web\HttpException;
use yii\web\View;
use yii\base\Action;

class ViewAction extends Action
{
    public function run($id, View $view): string
    {
        $id = (int)$id;
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new HttpException(
                404,
                'Запрошенная страница задания не найдена'
            );
        }

        if ($task->status_task !== 'Новое' && $task->status_task !== 'Выполнено') {
            if ($this->controller->user->id !== $task->client_id && $this->controller->user->id !== $task->doer_id) {
                $this->controller->redirect('/tasks/index');
            }
        }

        $taskActions = new TaskActions($task->client_id, $this->controller->user->id, $task->doer_id);

        $view->params['task_id'] = $id;
        $view->params['task'] = $task;
        $view->params['user_id'] = $this->controller->user->id;
        $view->params['user'] = $this->controller->user;
        $view->params['doer_id'] = $task->doer_id;
        $view->params['client_id'] = $task->client_id;
        $view->params['longitude'] = $task->longitude;
        $view->params['latitude'] = $task->latitude;

        return $this->controller->render('view', [
            'taskActions' => $taskActions,
            'task' => $task,
            'user' => $this->controller->user
        ]);
    }
}
