<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\notifications\Notifications;
use frontend\models\opinions\Opinions;
use frontend\models\opinions\RequestForm;
use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use Yii;
use yii\base\Action;
use yii\base\BaseObject;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RequestAction extends Action
{
    public function run()
    {
        $completeForm = new RequestForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $completeForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($completeForm);
        }

        if ($completeForm->load($request->post())) {
            if ($completeForm->validate()) {
                $opinion = new Opinions(['attributes' => $completeForm->attributes]);
                $opinion->save(false);

                $user_doer = Users::findOne($opinion->doer_id);
                $user_client = $this->controller->user;
                $opinions = Opinions::find()->where(['doer_id' => $user_doer->id]);
                $task = Tasks::findOne($opinion->task_id);

                if (isset($opinion->completion) && isset($task->status_task)) {
                    $opinion->completion == 1 ?
                        $task->status_task = 'Выполнено' :
                        $task->status_task = 'Провалено';
                    $task->save();
                }

                if (isset($user_doer->rating) && isset($user_doer->done_tasks) && isset($user_doer->failed_tasks) && isset($user_doer->created_tasks) && isset($user_doer->opinions_count)) {
                    $user_doer->rating = $opinions->select('AVG(rate) as rating');
                    $tasks = new Tasks();
                    $user_doer->done_tasks = $tasks->countUsersTasks($task->status_task, $user_doer);
                    $user_doer->failed_tasks = $tasks->countUsersTasks($task->status_task, $user_doer);
                    $user_client->created_tasks = $tasks->countUsersTasks($task->status_task, $user_client);
                    $user_doer->opinions_count = $opinions->count();
                    $user_client->save(false);
                    $user_doer->save(false);
                }

                $notification = new Notifications([
                    'notification_category_id' => 5,
                    'setting' => 'is_subscribed_reviews',
                    'task_id' => $task->id,
                    'user_id' => $user_doer->id,
                    'visible' => 1,
                ]);
                $notification->save(false);
                $notification->addNotification();
            }
        }

        return $this->controller->redirect([
            'tasks/index'
        ]);
    }
}
