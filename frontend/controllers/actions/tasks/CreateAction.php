<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileTask;
use frontend\models\tasks\Tasks;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CreateAction extends Action
{
    public function run()
    {
        $createTaskForm = new CreateTaskForm();
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($this->controller->user->user_role == 'doer') {
            return $this->controller->redirect(['tasks/index']);
        }

        if ($request->isAjax && $createTaskForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($createTaskForm);
        }

        if ($createTaskForm->load($request->post())) {
            if ($createTaskForm->validate()) {
                $session->setFlash(
                    'validate',
                    true
                );

                $createTaskForm->getAddress();
                $task = new Tasks(['attributes' => $createTaskForm->attributes]);
                $task->save();

                if ($createTaskForm->upload()) {
                    foreach ($createTaskForm->file_item as $file) {
                        $fileTask = new FileTask([
                            'file_item' => $file,
                            'task_id' => $task->id]);
                        $fileTask->save(false);
                    }
                }

                return $this->controller->redirect(['tasks/view', 'id' => $task->id]);
            } else {
                $session->setFlash(
                    'validate',
                    false
                );
                $session->setFlash(
                    'form-errors',
                    $createTaskForm->getErrors()
                );
            }
        }

        return $this->controller->render('create', [
                'createTaskForm' => $createTaskForm,
                'user' => $this->controller->user
            ]
        );
    }
}
