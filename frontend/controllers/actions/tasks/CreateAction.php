<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileTaskForm;
use frontend\models\tasks\Tasks;
use Yii;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\UploadedFile;

class CreateAction extends BaseAction
{
    public $fileTaskForm;

    public function run()
    {
        $createTaskForm = new CreateTaskForm();
        $this->fileTaskForm = new FileTaskForm();
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($this->user->user_role == 'doer') {
            return $this->controller->redirect(['tasks/index']);
        }

        if ($request->isAjax && $createTaskForm->load($request->post()) && $this->fileTaskForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validateMultiple([$createTaskForm, $this->fileTaskForm]);
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

                $task->save(false);
                $this->uploadFile($task);

                return $this->controller->redirect(['tasks/view', 'id' => $task->id]);
            }

            else {
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

        return $this->controller->render('create', ['createTaskForm' => $createTaskForm, 'fileTaskForm' => $this->fileTaskForm, 'user' => $this->user]);
    }

    private function uploadFile($task): void
    {
        $request = Yii::$app->request;

        if ($this->fileTaskForm->load($request->post())) {
            $this->fileTaskForm->file_item = UploadedFile::getInstances($this->fileTaskForm, 'file_item');

            if (!empty($this->fileTaskForm->file_item) && $this->fileTaskForm->upload()) {
                $files = array();

                foreach ($this->fileTaskForm->file_item as $fileItem) {
                    $files[] = [$fileItem, $task->id];
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('file_task',
                        ['file_item', 'task_id'],
                        $files)
                    ->execute();
                return;
            }
        }
    }
}
