<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\opinions\RequestForm;
use frontend\models\opinions\Opinions;
use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;

class RequestAction extends BaseAction
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
                $user_client = Users::findOne($opinion->client_id);
                $opinions = Opinions::find()->where(['doer_id' => $user_doer->id]);
                $task = Tasks::findOne($opinion->task_id);
                $opinion->completion == 1 ? $task->status_task = 'Выполнено' : $task->status_task = 'Провалено';
                $task->save();
                $user_doer->rating = $opinions->select('AVG(rate) as rating');
                $tasks_doer = Tasks::find()->where(['doer_id' => $user_doer->id]);
                $tasks_client = Tasks::find()->where(['client_id' => $user_client->id]);
                $opinion->completion == 1 ?
                    $user_doer->done_tasks = $tasks_doer->andWhere(['status_task' => 'Выполнено'])->count() :
                    $user_doer->failed_tasks = $tasks_doer->andWhere(['status_task' => 'Провалено'])->count();
                $user_client->created_tasks = $tasks_client->andWhere(['status_task' => 'Выполнено'])->count();
                $user_doer->opinions_count = $opinions->count();
                $user_doer->save();
                $user_client->save();
                Yii::$app->runAction('event/add-notification', ['task_id' => $task->id, 'notification_category' => 5, 'user_id' => $user_doer->id]);
            }
        }

        return $this->controller->redirect([
            'tasks/index'
        ]);
    }
}
