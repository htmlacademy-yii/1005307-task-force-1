<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\CreateTaskForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\models\tasks\FileUploadForm;
use Yii;

class CreateAction extends BaseAction
{
    public $fileUploadForm;
    public function run()
    {
        $createTaskForm = new CreateTaskForm();
        $this->fileUploadForm = new FileUploadForm();
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($this->user->user_role == 'doer') {
            return $this->controller->redirect(['tasks/index']);
        }

        if ($request->isAjax && $createTaskForm->load($request->post()) && $this->fileUploadForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validateMultiple([$createTaskForm, $this->fileUploadForm]);
        }

        if ($createTaskForm->load($request->post())) {
            if ($createTaskForm->validate()) {
                $session->setFlash(
                    'validate',
                    true
                );
                $task = new Tasks(['attributes' => $createTaskForm->attributes]);

                if ($task->address ?? null) {
                    $address = $createTaskForm->getGeoData($task->address);
                    $coordinates = $createTaskForm->getCoordinates($task->address);
                    $task->longitude = $coordinates[0] ?? null;
                    $task->latitude = $coordinates[1] ?? null;
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

        return $this->controller->render('create', ['createTaskForm' => $createTaskForm, 'fileUploadForm' => $this->fileUploadForm, 'user' => $this->user]);
    }

    private function uploadFile($task): void
    {
        $request = Yii::$app->request;

        if ($this->fileUploadForm->load($request->post())) {
            $this->fileUploadForm->file_item = UploadedFile::getInstances($this->fileUploadForm, 'file_item');

            if (!empty($this->fileUploadForm->file_item) && $this->fileUploadForm->upload()) {
                $files = array();

                foreach ($this->fileUploadForm->file_item as $fileItem) {
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
