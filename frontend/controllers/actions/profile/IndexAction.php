<?php

declare(strict_types=1);

namespace frontend\controllers\actions\profile;

use frontend\models\account\ProfileForm;
use frontend\models\cities\Cities;
use frontend\models\users\Users;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class IndexAction extends Action
{
    public function run()
    {
        $users = new Users();
        $profileForm = new ProfileForm();
        $request = \Yii::$app->request;

        if (!$profileForm->load($request->post())) {
            $profileForm->loadCurrentUserData($this->controller->user);
        }

        if ($request->isAjax && $profileForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->end();

            return ActiveForm::validate($profileForm);
        }

        if ($profileForm->load($request->post())) {
            if (property_exists($profileForm, 'avatar') && property_exists($profileForm, 'photo')) {
                $profileForm->avatar = UploadedFile::getInstance($profileForm, 'avatar');
                $profileForm->photo = UploadedFile::getInstances($profileForm, 'photo');

                if ($profileForm->validate()) {
                    $profileForm->saveProfileData($this->controller->user);
                    $city = new Cities();
                    $city->setSessionCity($this->controller->user);

                    return $this->controller->redirect(['users/view', 'id' => $this->controller->user->id]);
                }
            }
        }
        return $this->controller->render(
            'index',
            [
                'user' => $this->controller->user,
                'profileForm' => $profileForm,
            ]
        );
    }
}
