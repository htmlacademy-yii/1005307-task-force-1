<?php
declare(strict_types=1);

namespace frontend\controllers;

class SiteController extends SecuredController
{
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'set-cities' => \frontend\controllers\actions\site\SetCitiesAction::class,
        ];
    }
}
