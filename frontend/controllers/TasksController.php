<?php


declare(strict_types=1);

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\models\Tasks as Tasks;

/**
 * Users controller
 */
class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $tasks = Tasks::find()
            ->where(['status_task_id' => '1'])->asArray()->all();
        {
            return $this->render('index', ['tasks' => $tasks]);
        }
    }
}
