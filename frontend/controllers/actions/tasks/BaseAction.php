<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\tasks\Tasks;
use yii\base\Action;

abstract class BaseAction extends Action
{
    public $task;
    public $doer_id;
    public $client_id;
    public $id;

    public function init()
    {
        $id = (int)$this->id;
        $this->task = Tasks::findOne($id);
        $this->doer_id = $this->task->doer_id;
        $this->client_id = $this->task->client_id;
        parent::init();
    }
}
