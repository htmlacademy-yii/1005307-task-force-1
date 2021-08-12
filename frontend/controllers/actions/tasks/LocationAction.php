<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;
use frontend\models\tasks\CreateTaskForm;
use frontend\models\tasks\Tasks;
use Yii;

class LocationAction extends BaseAction
{
    public function run(): array {
        if (Yii::$app->request->isAjax) {
            $createTaskForm = new CreateTaskForm();
            $coordinates = $createTaskForm->getCoordinates($address);
            $result = array();

                $result[] = array('address' => $address,
                    'longitude' => $coordinate[0],
                    'latitude' => $coordinate[1]);
                $task->longitude = $coordinate[0] ?? null;
                $task->latitude = $coordinate[1] ?? null;
//            return $createTaskForm->getCoordinates($address);
        }
        return $result;
    }
}
