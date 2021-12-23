<?php
declare(strict_types=1);

namespace frontend\controllers;

/**
 * Class TasksController
 * @package frontend\controllers
 */
class TasksController extends SecuredController
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'cancel' => \frontend\controllers\actions\tasks\CancelAction::class,
            'create' => \frontend\controllers\actions\tasks\CreateAction::class,
            'filter' => \frontend\controllers\actions\tasks\FilterCategoriesAction::class,
            'index' => \frontend\controllers\actions\tasks\IndexAction::class,
            'refuse' => \frontend\controllers\actions\tasks\RefuseAction::class,
            'refuse-response' => \frontend\controllers\actions\tasks\RefuseResponseAction::class,
            'request' => \frontend\controllers\actions\tasks\RequestAction::class,
            'response' => \frontend\controllers\actions\tasks\ResponseAction::class,
            'start-work' => \frontend\controllers\actions\tasks\StartWorkAction::class,
            'view' => \frontend\controllers\actions\tasks\ViewAction::class,
        ];
    }
}
