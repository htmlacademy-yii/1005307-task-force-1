<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskSearchForm;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileUploadForm;
use frontend\models\tasks\FileTask;
use frontend\models\users\Users;
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

    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user)) {
            $this->user = \Yii::$app->user->getIdentity();
        }
    }

    private $task;

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
        $fileUploadForm = new FileUploadForm();

        if ($this->user['user_role'] === 'doer') {
            return $this->redirect(['tasks/index']);
        }

        if (Yii::$app->request->getIsPost()) {
            $createTaskForm->load(Yii::$app->request->post());
            $fileUploadForm->load(Yii::$app->request->post());
            $fileUploadForm->file_item = UploadedFile::getInstances($fileUploadForm, 'file_item');

            if ($createTaskForm->validate()) {
                $this->task = new Tasks(['attributes' => $createTaskForm->attributes]);
                $this->task->save(false);

                if (!empty($fileUploadForm->file_item) && $fileUploadForm->upload()) {
                    $files = array();

                    foreach ($fileUploadForm->file_item as $fileItem) {
                        $files[] = [$fileItem, $this->task['id']];
                    }

                    Yii::$app->db->createCommand()
                        ->batchInsert('file_task',
                            ['file_item', 'task_id'],
                            $files)
                        ->execute();
                }
            }
                return $this->redirect(['tasks/view', 'id' => $this->task['id']]);
            }

        return $this->render('create', ['createTaskForm' => $createTaskForm, 'fileUploadForm' => $fileUploadForm, 'user' => $this->user]);
    }
}
