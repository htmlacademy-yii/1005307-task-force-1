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
            'get-location' => \frontend\controllers\actions\tasks\LocationAction::class,
            'refuse' => \frontend\controllers\actions\tasks\RefuseAction::class,
            'create' => \frontend\controllers\actions\tasks\CreateAction::class,
            'response' => \frontend\controllers\actions\tasks\ResponseAction::class,
            'refuse-response' => \frontend\controllers\actions\tasks\RefuseResponseAction::class,
            'start-work' => \frontend\controllers\actions\tasks\StartWorkAction::class,
            'cancel' => \frontend\controllers\actions\tasks\CancelAction::class,
            'location' => \frontend\controllers\actions\tasks\LocationAction::class,
            'request' => \frontend\controllers\actions\tasks\RequestAction::class,
        ];
    }
}
