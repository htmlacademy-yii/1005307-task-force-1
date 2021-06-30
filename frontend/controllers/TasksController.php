<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\tasks\TaskSearchForm;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\FileTask;

use Yii;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{
    /**
     * @var bool|mixed|\yii\web\IdentityInterface|null
     */
    private $user;

    public function init()
    {
        parent::init();
        $this->user = \Yii::$app->user->getIdentity();
    }

    public function actionIndex(): string
    {
        $searchForm = new TaskSearchForm();
        $searchForm->load($this->request->post());
        $tasks = Tasks::getNewTasksByFilters($searchForm);
        return $this->render('index', compact('tasks', 'searchForm'));
    }

    public function actionView($id = null): string
    {
        $task = Tasks::getOneTask($id);

        if (empty($task)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        return $this->render('view', ['task' => $task]);
    }

    public function actionCreate() {
        $createTaskForm = new CreateTaskForm();

        if (Yii::$app->request->getIsPost()) {
            $createTaskForm->load(Yii::$app->request->post());

            if (!$createTaskForm->validate()) {
                $errors = $createTaskForm->getErrors();
            }

            $task = new Tasks(['attributes' => $createTaskForm->attributes]);

            if ($createTaskForm->validate()) {
                $task->save(false);
                return $this->redirect(['tasks/view', 'id' => $task['id']]);
            }
        }

        return $this->render('create', ['createTaskForm' => $createTaskForm, 'user' => $this->user]);
    }
}
