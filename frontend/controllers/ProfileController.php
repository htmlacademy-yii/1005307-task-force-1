<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\controllers\actions\profile\IndexAction;

class ProfileController extends SecuredController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}
