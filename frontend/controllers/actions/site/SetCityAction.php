<?php

declare(strict_types=1);

namespace frontend\controllers\actions\site;

use yii\base\Action;
use frontend\models\cities\SetCityForm;

use Yii;

class SetCityAction extends Action
{
    public function run()
    {
        $cityForm = new SetCityForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $cityForm->load($request->post())) {
            $session = Yii::$app->session;
            $session->set('city', $cityForm->city);
        }

        return $this->controller->redirect(['/tasks/']);
    }
}
