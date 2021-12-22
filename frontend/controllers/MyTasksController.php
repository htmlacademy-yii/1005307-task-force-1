<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\controllers\actions\myTasks\IndexAction;

/**
 * Class MyTasksController
 * @package frontend\controllers
 */
class MyTasksController extends SecuredController
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}
