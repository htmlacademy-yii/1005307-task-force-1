<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\Responses;
use yii\base\Action;
use yii\web\Response;

class RefuseResponseAction extends Action
{
    public function run(int $responseId): Response
    {
        $response = Responses::findOne($responseId);

        if (property_exists($response, 'is_refused')) {
            $response->is_refused = 1;
            $response->save(false);
        }


        return $this->controller->redirect([
            'tasks/view',
            'id' => $response->task_id
        ]);
    }
}
