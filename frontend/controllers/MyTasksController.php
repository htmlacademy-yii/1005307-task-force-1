<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\controllers\actions\myTasks\IndexAction;

class MyTasksController extends SecuredController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}
