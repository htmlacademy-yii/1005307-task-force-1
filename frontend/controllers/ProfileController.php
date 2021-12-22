<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\controllers\actions\profile\IndexAction;

/**
 * Class ProfileController
 * @package frontend\controllers
 */
class ProfileController extends SecuredController
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
