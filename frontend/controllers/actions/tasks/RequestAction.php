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

                $opinions = new Opinions(['attributes' => $completeForm->attributes]);
                $opinions->save(false);

                $task = Tasks::findOne($opinions->task_id);
                $user_doer = Users::findOne($opinions->doer_id);
                $user_client = Users::findOne($opinions->client_id);
                $opinion = Opinions::find()->where(['doer_id' => $user_doer->id]);
                $user_doer->failed_tasks = $opinion->where(['completion' => '2'])->count();
                $user_doer->done_tasks = $opinion->where(['completion' => '1'])->count();
                $user_client->done_tasks = $opinion->where(['completion' => '1'])->count();
                $user_doer->rating = $opinion->select('AVG(rate) as rating');
                $user_doer->save();
                $user_client->save();
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
