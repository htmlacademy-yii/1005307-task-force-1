<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use yii\base\Action;
use yii\web\HttpException;
use yii\web\View;

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

        if (property_exists($task, 'status_task') && $task->status_task !== 'Новое' && $task->status_task !== 'Выполнено') {
            if (property_exists($task, 'client_id') && property_exists($task, 'doer_id') && $this->controller->user->id !== $task->client_id && $this->controller->user->id !== $task->doer_id) {
                $this->controller->redirect('/tasks/');
            }
        }

        $view->params['task_id'] = $id;
        $view->params['task'] = $task;
        $view->params['user_id'] = $this->controller->user->id;
        $view->params['user'] = $this->controller->user;
        $view->params['doer_id'] = $task->doer_id;
        $view->params['client_id'] = $task->client_id;
        $view->params['longitude'] = $task->longitude;
        $view->params['latitude'] = $task->latitude;

        return $this->controller->render('view', [
            'task' => $task,
            'user' => $this->controller->user
        ]);
    }
}
