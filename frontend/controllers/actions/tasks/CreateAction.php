<?php
declare(strict_types=1);
/*
*/

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileTask;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\UploadedFile;

use Yii;

class CreateAction extends BaseAction
{
    public function run()
    {
        $createTaskForm = new CreateTaskForm();
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($this->user->user_role == 'doer') {
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
                $task = new Tasks(['attributes' => $createTaskForm->attributes]);

                if ($task->address ?? null) {
                    $coordinates = $createTaskForm->getCoordinates($task->address);
                    $task->longitude = $coordinates[0] ?? null;
                    $task->latitude = $coordinates[1] ?? null;
                    $task->city_id = $this->user->city_id;
                }

                $task->save();
                $createTaskForm->file_item = UploadedFile::getInstances($createTaskForm, 'file_item');
                $createTaskForm->upload();

                foreach ($createTaskForm->file_item as $fileItem) {
                    $fileTask = new FileTask([
                        'file_item' => $fileItem,
                        'task_id' => $task->id]);
                    $fileTask->save(false);
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

        return $this->controller->render('create', ['createTaskForm' => $createTaskForm, 'user' => $this->user]);
    }
}
