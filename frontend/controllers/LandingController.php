<?php
declare(strict_types=1);

namespace frontend\controllers;
use app\models\tasks\Tasks;

use Yii;
use yii\base\BaseObject;
use yii\web\Controller;

class LandingController extends Controller
{
    public function beforeAction($action)
    {
        return true;
    }
    public function actionIndex(): string
    {
        $this->layout = 'anon';
        $tasks = Tasks::getLastTasks();
        return $this->render('index', ['tasks' => $tasks]);
    }
}
