<?php
declare(strict_types=1);

namespace frontend\controllers;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends SecuredController
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'set-city' => \frontend\controllers\actions\site\SetCityAction::class,
        ];
    }
}
