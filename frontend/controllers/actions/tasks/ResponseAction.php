<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\ResponseForm;
use frontend\models\responses\Responses;
use frontend\models\tasks\Tasks;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;

class ResponseAction extends BaseAction
{
    public function run()
    {
        $responseForm = new ResponseForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $responseForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($responseForm);
        }

        if ($responseForm->load($request->post())) {
            if ($responseForm->validate()) {
                $response = new Responses(['attributes' => $responseForm->attributes]);
                $response->save(false);
                $task = Tasks::findOne($response->task_id);
                Yii::$app->runAction('event/add-notification', ['task_id' => $responseForm->task_id, 'notification_category' => 1, 'user_id' => $task->client_id]);
            }
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $responseForm->task_id
        ]);
    }
}
