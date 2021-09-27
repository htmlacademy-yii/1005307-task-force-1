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
        $session = Yii::$app->session;



        if (empty($loginForm->password) && empty($loginForm->email)) {
            if ($request->isAjax && $loginForm->load($request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                Yii::$app->end();

                return ActiveForm::validate($loginForm);
            }
        }
        if ($loginForm->load($request->post())) {
            if ($loginForm->validate()) {
                $session->setFlash(
                    'validate',
                    true
                );
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                return $this->controller->redirect(['tasks/']);
            } else {
                $session->setFlash(
                    'validate',
                    false
                );
                $session->setFlash(
                    'form-errors',
                    'Введите верный логин/пароль'
                );
            }
        }

        return $this->controller->redirect(['landing/index']);
    }
}
