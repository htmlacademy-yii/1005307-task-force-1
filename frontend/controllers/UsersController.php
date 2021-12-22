<?php
declare(strict_types=1);

namespace frontend\controllers;

/**
 * Class UsersController
 * @package frontend\controllers
 */
class UsersController extends SecuredController
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'add-favourite' => \frontend\controllers\actions\users\AddFavouriteAction::class,
            'index' => \frontend\controllers\actions\users\IndexAction::class,
            'view' => \frontend\controllers\actions\users\ViewAction::class,
        ];
    }
}
