<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task_actions\CompleteForm;
use frontend\models\opinions\Opinions;
use frontend\models\tasks\Tasks;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;

class CompleteAction extends BaseAction
{
    public function run()
    {
        $completeForm = new CompleteForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $completeForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($completeForm);
        }

        if ($completeForm->load($request->post())) {
            if ($completeForm->validate()) {

                $opinions = new Opinions(['attributes' => $completeForm->attributes]);
                $opinions->save(false);

                $task = Tasks::findOne($opinions->task_id);
                $opinions->completion == 1 ? $task->status_task = 'Завершено' : $task->status_task = 'Провалено';
                $task->save();
            }
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $completeForm->task_id
        ]);
    }
}
