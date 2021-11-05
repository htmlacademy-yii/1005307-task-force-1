<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\cities\SetCityForm;
use Yii;

class SiteController extends SecuredController
{
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function setCity(): \yii\web\Response
    {
        $cityForm = new SetCityForm();
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $session = Yii::$app->session;
            $session->set('city', $cityForm->city);
        //    $cityForm->submit();
          //  var_dump($session['city']);
        }

        return $this->redirect(['tasks/']);
    }
}
