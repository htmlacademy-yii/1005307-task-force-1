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
                $task = Tasks::findOne($completeForm->task_id);
                $task->status_task = $completeForm->completion === 1 ? 'done' : 'failed';
                $task->save();

                $opinions = new Opinions(['attributes' => $completeForm->attributes]);
                $opinions->save(false);
            }
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $completeForm->task_id
        ]);
    }
}
