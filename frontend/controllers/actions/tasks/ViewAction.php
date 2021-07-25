<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use yii\web\NotFoundHttpException;

class ViewAction extends BaseAction
{
    public function run($id)
    {
        $task = Tasks::getOneTask($id);

        if (empty($task)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        return $this->controller->render('view', ['task' => $task, 'user' => $this->user]);
    }
}
