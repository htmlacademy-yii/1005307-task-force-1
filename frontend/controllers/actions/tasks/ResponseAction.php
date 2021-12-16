<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\notifications\Notifications;
use frontend\models\responses\ResponseForm;
use frontend\models\responses\Responses;
use frontend\models\tasks\Tasks;
use frontend\models\users\UserOptionSettings;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ResponseAction extends Action
{
    public $task;

    public function run()
    {
        $responseForm = new ResponseForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $responseForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($responseForm);
        }

        if ($responseForm->load($request->post())) {
            $responseForm->validate();
            if ($responseForm->validate()) {
                $response = new Responses(['attributes' => $responseForm->attributes]);
                $response->save(false);

                $this->task = Tasks::findOne($response->task_id);
                if (property_exists(new Tasks(), 'responses_count')) {
                    $this->task->responses_count = Responses::find()
                        ->where(['task_id' => $response->task_id])->count();
                    $this->task->save();
                }

                $user_set = UserOptionSettings::findOne($this->task->client_id);

                if (property_exists(new UserOptionSettings(), 'is_subscribed_actions') && $user_set['is_subscribed_actions'] == 1) {
                    $notification = new Notifications([
                        'notification_category_id' => 1,
                        'task_id' => $this->task->id,
                        'user_id' => $this->task->client_id,
                        'visible' => 1
                    ]);

                    $notification->save(false);
                    $notification->addNotification();
                }
            }
        }

        return $this->controller->redirect([
            'task/view',
            'id' => $this->task->id
        ]);
    }
}
