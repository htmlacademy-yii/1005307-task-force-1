<?php

declare(strict_types=1);

namespace frontend\controllers\actions\settings;

use frontend\models\account\SettingsForm;
use frontend\models\opinions\Opinions;
use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use yii\base\Action;
use yii\base\BaseObject;
use yii\web\Response;
use yii\widgets\ActiveForm;

class IndexAction extends Action
{

    public $user;

    public function init()
    {
        parent::init();
        if (!empty(\Yii::$app->user)) {
            $this->user = \Yii::$app->user->getIdentity();
        }
    }

    public function run()
    {
        $settingsForm = new SettingsForm();
        $request = \Yii::$app->request;
        $user = Users::findOne(\Yii::$app->user->getId());

        if ($request->isAjax && $settingsForm->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($settingsForm);
        }

        if ($settingsForm->load($request->post())) {
            if ($settingsForm->saveProfileData($user)) {

                return $this->controller->redirect(['users/view', 'id' => $user->id]);
            }
        }

        return $this->controller->render(
            '/settings/index',
            ['user' => $user,
                'settingsForm' => $settingsForm]
        );
    }
}
