<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskSearchForm;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileUploadForm;
use frontend\models\tasks\FileTask;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\web\UploadedFile;

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

    public function actionIndex(): string
    {
        $searchForm = new TaskSearchForm();
        $searchForm->load($this->request->post());
        $query = Tasks::getNewTasksByFilters($searchForm);
        $page = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $tasks = $query->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $this->render('index', compact('tasks', 'searchForm', 'page'));
    }

    public function actionView($id = null): string
    {
        $task = Tasks::getOneTask($id);

        if (!$task) {
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
            if ($fileUploadForm->upload()) {
              //  foreach ($fileUploadForm->file_item as $file_task) {
                    $file_task = new FileTask(['attributes' => $fileUploadForm->attributes]);
              //  }
            }
            $task = new Tasks(['attributes' => $createTaskForm->attributes]);

            if ($createTaskForm->validate()) {
                $task->save(false);
                $file_task->save(false);
                return $this->redirect(['tasks/view', 'id' => $task['id']]);
            }
        }

        return $this->render('create', ['createTaskForm' => $createTaskForm, 'fileUploadForm' => $fileUploadForm, 'user' => $this->user]);
    }
}
