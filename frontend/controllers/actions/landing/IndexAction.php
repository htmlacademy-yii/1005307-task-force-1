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
