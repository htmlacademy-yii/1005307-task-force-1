<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\responses\Responses;

class RefuseResponseAction extends BaseAction
{
    public function run(int $responseId)
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
