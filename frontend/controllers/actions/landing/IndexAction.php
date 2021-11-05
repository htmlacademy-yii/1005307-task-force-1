<?php

declare(strict_types=1);

namespace frontend\controllers\actions\landing;

use frontend\models\tasks\Tasks;
use yii\data\ArrayDataProvider;
use yii\base\Action;

class IndexAction extends Action
{
    public function run()
    {
        $data = Tasks::getLastTasks();
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);

        return $this->controller->render('index', ['dataProvider' => $dataProvider]);
    }
}
// сохранение города текущей сессии - для поиска заданий и создания задания
// Отправка уведомления на email - попрвить данные почты
// Авторизация через соцсети
// бережливость
// Хранение счётчиков в redis
// Проверка email на существование
