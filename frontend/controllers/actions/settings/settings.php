<?php

declare(strict_types=1);

namespace frontend\controllers\actions\settings;
use yii\base\Action;

class IndexAction extends Action
{
    public function run()
    {
        return $this->controller->render('index');
    }
}
