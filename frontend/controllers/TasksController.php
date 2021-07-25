<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskSearchForm;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileUploadForm;
use yii\base\BaseObject;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\web\Response;

use Yii;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{
    private $user;
    private $fileUploadForm;
    private $errors;

    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user)) {
            $this->user = \Yii::$app->user->getIdentity();
        }
    }

    public function actionIndex(): string
    {
        $searchForm = new TaskSearchForm();
        $searchForm->search(Yii::$app->request->queryParams);

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

    public function actionJson()
    {
        $tasks = Tasks::find()->asArray()->all();

        $response = Yii::$app->response;
        $response->data = $tasks;
        $response->format = Response::FORMAT_JSON;

        return $response;
    }

    public function actionCreate()
    {
        $createTaskForm = new CreateTaskForm();
        $this->fileUploadForm = new FileUploadForm();
        $request = Yii::$app->request;

        if ($this->user['user_role'] === 'doer') {
            return $this->redirect(['tasks/index']);
        }

        if ($request->isAjax && $createTaskForm->load($request->post()) && $this->fileUploadForm->load($request->post()))  {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validateMultiple([$createTaskForm, $this->fileUploadForm]);
        }

        if ($createTaskForm->load($request->post()) && $createTaskForm->validate()) {
            $task = new Tasks(['attributes' => $createTaskForm->attributes]);
            $task->save(false);
            $this->uploadFile($task);

            return $this->redirect(['tasks/view', 'id' => $task['id']]);
        }

        return $this->render('create', ['createTaskForm' => $createTaskForm, 'fileUploadForm' => $this->fileUploadForm, 'user' => $this->user]);
    }

    private function uploadFile($task): void
    {
        $request = Yii::$app->request;

        if ($this->fileUploadForm->load($request->post())) {
            $this->fileUploadForm->file_item = UploadedFile::getInstances($this->fileUploadForm, 'file_item');

            if (!empty($this->fileUploadForm->file_item) && $this->fileUploadForm->upload()) {
                $files = array();

                foreach ($this->fileUploadForm->file_item as $fileItem) {
                    $files[] = [$fileItem, $task['id']];
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
