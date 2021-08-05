<?php
declare(strict_types=1);

namespace frontend\controllers;

class TasksController extends SecuredController
{
    public function actions(): array
    {
        return [
            'index' => \frontend\controllers\actions\tasks\IndexAction::class,
            'view' => \frontend\controllers\actions\tasks\ViewAction::class,
            'filter' => \frontend\controllers\actions\tasks\FilterAction::class,
            'refuse' => \frontend\controllers\actions\tasks\RefuseAction::class,
            'create' => \frontend\controllers\actions\tasks\CreateAction::class,
            'response' => \frontend\controllers\actions\tasks\ResponseAction::class,
            'refuse-response' => \frontend\controllers\actions\tasks\RefuseResponseAction::class,
            'start-work' => \frontend\controllers\actions\tasks\StartWorkAction::class,
            'complete' => \frontend\controllers\actions\tasks\CompleteAction::class,
        ];
    }
}
