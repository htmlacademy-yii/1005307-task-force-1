<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\Responses;
use yii\web\Response;
use yii\base\Action;

class RefuseResponseAction extends Action
{
    public function run(int $responseId): Response
    {
        $response = Responses::findOne($responseId);
        $response->is_refused = 1;
        $response->save(false);

        return $this->controller->redirect([
            'tasks/view',
            'id' => $response->task_id
        ]);
    }
}
