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

use Yii;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{
    /**
     * @var bool|mixed|\yii\web\IdentityInterface|null
     */
    private $user;

    /**
     * @throws \Throwable
     */
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
        $dataProvider = $searchForm->search(Yii::$app->request->queryParams);

        $dataProvider = new ActiveDataProvider([
            'query' => Tasks::getNewTasksByFilters($searchForm),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchForm' => $searchForm]);
    }

    /**
     * @throws NotFoundHttpException
     */
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

        if (Yii::$app->request->getIsPost()) {
            $createTaskForm->load(Yii::$app->request->post());
            $fileUploadForm->load(Yii::$app->request->post());
            $fileUploadForm->file_item = UploadedFile::getInstance($fileUploadForm, 'file_item');

            if (!$createTaskForm->validate()) {
                $errors = $createTaskForm->getErrors();
            }

            if (!$fileUploadForm->validate()) {
                $errors = $fileUploadForm->getErrors();
            }
            $this->task = new Tasks(['attributes' => $createTaskForm->attributes]);

            if ($fileUploadForm->upload()) {
                $file_task = new FileTask(['attributes' => $fileUploadForm->attributes]);
                $file_task->getTask();
            }

            if ($createTaskForm->validate()) {
                $this->task->save(false);
                $file_task->save(false);
                return $this->redirect(['tasks/view', 'id' => $this->task['id']]);
            }
        }

        return $this->render('create', ['createTaskForm' => $createTaskForm, 'fileUploadForm' => $fileUploadForm, 'user' => $this->user, 'task' => $this->task]);
    }
}
