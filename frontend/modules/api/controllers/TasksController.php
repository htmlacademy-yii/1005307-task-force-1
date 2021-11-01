<?php

namespace frontend\modules\api\controllers;

use frontend\models\tasks\Tasks;
use yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function actionViewExecutantTasks(): array
    {
        $user_id = Yii::$app->user->getId();

        return Tasks::findAll(['doer_id' => $user_id]);
    }

}
