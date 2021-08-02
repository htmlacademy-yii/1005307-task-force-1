<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\account\LoginForm;
use yii\base\Action;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LoginAction extends Action
{
    public function run()
    {
        $loginForm = new LoginForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $loginForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($loginForm);
        }

        if ($loginForm->load($request->post())) {
            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                return $this->controller->redirect(['tasks/']);
            }
        }

        return $this->controller->redirect(['landing/index']);
    }
}
