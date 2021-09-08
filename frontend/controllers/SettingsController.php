<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\controllers\actions\settings\IndexAction;

class SettingsController extends SecuredController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}
