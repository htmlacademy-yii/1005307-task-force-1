<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskActions;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;
use yii\web\View;
use yii;
use yii\web\HttpException;

class ViewAction extends BaseAction
{
    public function run($id, View $view): string
    {
        $id = (int)$id;
        $task = Tasks::find()->andWhere(['id' => $id])->one();
        if (!$task) {
            throw new HttpException(
                404,
                'Запрошенная страница задания не найдена'
            );
        }
        if ($task->status_task !== 'Новое' && $task->status_task !== 'Выполнено') {
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
        $view->params['longitude'] = $task->longitude;
        $view->params['latitude'] = $task->latitude;

        return $this->controller->render('view', ['taskActions' => $taskActions, 'task' => $task, 'user' => $this->user]);
    }
}
