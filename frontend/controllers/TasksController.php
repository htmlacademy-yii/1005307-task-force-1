<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskSearchForm;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileUploadForm;
use frontend\models\tasks\FileTask;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

use Yii;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{
    private $user;

    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user)) {
            $this->user = \Yii::$app->user->getIdentity();
        }
    }

    private $task;
    private $file_task;

    public function actionIndex(): string
    {
        $searchForm = new TaskSearchForm();
        $dataProvider = $searchForm->search(Yii::$app->request->queryParams);

        $dataProvider = new ActiveDataProvider([
            'query' => Tasks::getNewTasksByFilters($searchForm),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }

    public function actionView($id = null): string
    {
        $task = Tasks::getOneTask($id);

        if (empty($task)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        return $this->render('view', ['task' => $task]);
    }

    public function actionCreate()
    {
        $createTaskForm = new CreateTaskForm();
        $fileUploadForm = new FileUploadForm();

        if ($this->user['user_role'] === 'doer') {
            return $this->redirect(['tasks/index']);
        }

        if ($createTaskForm->load(Yii::$app->request->post()) && $fileUploadForm->load(Yii::$app->request->post())) {
            if ($createTaskForm->validate()) {
                //  $this->file_task = UploadedFile::getInstances($fileUploadForm, 'file_input[]');
                $this->task = new Tasks(['attributes' => $createTaskForm->attributes]);
                $this->task->save(false);
                $fileItems = UploadedFile::getInstances($fileUploadForm, 'file_item');

                foreach ($fileItems as $fileItem) {
                    if ($fileUploadForm->upload()) {
                        $fileUploadForm->file_item = $fileItem;
                        $fileUploadForm->task_id = $this->task['id'];
                        $this->task = new FileTask(['attributes' => $fileUploadForm->attributes]);
                        $this->task->save(false);
                    }
                }
                return $this->redirect(['tasks/view', 'id' => $this->task['id']]);
            }
        }

        /*  if (Yii::$app->request->getIsPost()) {
              $createTaskForm->load(Yii::$app->request->post());
              $fileUploadForm->load(Yii::$app->request->post());
              $fileUploadForm->file_item = UploadedFile::getInstances($fileUploadForm, 'file_item');

              if (!$createTaskForm->validate()) {
                  $errors = $createTaskForm->getErrors();
              }

              $this->task = new Tasks(['attributes' => $createTaskForm->attributes]);

              if ($fileUploadForm->upload()) {
                  $this->file_task = new FileTask(['attributes' => $fileUploadForm->attributes]);
              }


              if ($createTaskForm->validate()) {
                  $this->task->save(false);
                  if ($this->file_task) {
                 //     if ($fileUploadForm->upload()) {
                 //         foreach ($this->file_task as $file) {
                      $this->file_task->task_id = $this->task['id'];
                      $this->file_task->file_item = $fileUploadForm->file_item;
                      $this->file_task->save(false, ['task_id', 'file_item']);
               //           }
                 //     }
                  }
                  //  $this->task->save(false);
                  //  if ($this->file_task) {
                  //      foreach ($this->file_task as $file)
                  //      }
              }
              return $this->redirect(['tasks/view', 'id' => $this->task['id']]);

          }*/


        return $this->render('create', ['createTaskForm' => $createTaskForm, 'fileUploadForm' => $fileUploadForm, 'user' => $this->user, 'task' => $this->task]);
    }
}
