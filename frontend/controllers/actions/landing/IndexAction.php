<?php

declare(strict_types=1);

namespace frontend\controllers\actions\landing;

use frontend\models\tasks\TaskSearchForm;
use yii\base\Action;
use yii\data\ArrayDataProvider;

class IndexAction extends Action
{
    public function run()
    {
        $taskForm = new TaskSearchForm;
        $data = $taskForm->getLastTasks(\Yii::$app->request->queryParams);
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
// Отправка уведомления на email - попрвить данные почты
// Авторизация через соцсети
// бережливость
// Хранение счётчиков в redis
