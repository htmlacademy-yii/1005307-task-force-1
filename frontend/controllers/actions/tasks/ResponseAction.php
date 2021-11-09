<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\notifications\Notifications;
use frontend\models\responses\ResponseForm;
use frontend\models\responses\Responses;
use frontend\models\tasks\Tasks;
use frontend\models\users\UserOptionSettings;
use frontend\models\users\Users;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

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

                $notification = new Notifications();
                $notification->notification_category_id = 1;
                $notification->task_id = $task->id;
                $notification->visible = 1;
                $notification->user_id = $this->user->id;
                $notification->save();

                $notification->addNotification(
                    $task->id,
                    1,
                    $this->user,
                    'is_subscribed_actions'
                );
          //      var_dump();
            }
        }

        return $this->controller->redirect([
            'tasks/view',
            'id' => $responseForm->task_id
        ]);
    }
}
