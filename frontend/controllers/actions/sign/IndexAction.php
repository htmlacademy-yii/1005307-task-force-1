<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;

use frontend\models\{users\UserOptionSettings, users\Users};
use frontend\models\account\SignForm;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

class IndexAction extends Action
{
    public function run()
    {
        $signForm = new SignForm();
        $request = Yii::$app->request;

        if ($request->isAjax && $signForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($signForm);
        }

        if ($signForm->load($request->post()) && $signForm->validate()) {
            $user = new Users(['attributes' => $signForm->attributes]);
            $user->password = Yii::$app->security->generatePasswordHash($signForm->password);
            $user->save(false);

            $userOptionSettings = new UserOptionSettings();
            $userOptionSettings->user_id = $user->id;
            $userOptionSettings->is_subscribed_messages = 1;
            $userOptionSettings->is_subscribed_actions = 1;
            $userOptionSettings->is_subscribed_reviews = 1;
            $userOptionSettings->is_hidden_account = 0;
            $userOptionSettings->is_hidden_contacts = 0;
            $userOptionSettings->save();

            $this->controller->goHome();
        }

        return $this->controller->render('index', [
            'signForm' => $signForm
        ]);
    }
}
