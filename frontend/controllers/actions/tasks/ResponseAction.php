<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use frontend\models\task_actions\ResponseForm;
use frontend\models\responses\Responses;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;

class ResponseAction extends BaseAction
{
    public function run(): array
    {
        $responseForm = new ResponseForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $responseForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($responseForm);
        }

        if ($responseForm->load($request->post())) {
            if ($responseForm->validate()) {
                $response = new Responses(['attributes' => $responseForm->attributes]);
                $response->save(false);
            }
        }
    }
}
