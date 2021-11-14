<?php

declare(strict_types=1);

namespace frontend\controllers\actions\profile;

use frontend\models\account\ProfileForm;
use frontend\models\users\PortfolioPhoto;
use yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class IndexAction extends Action
{

    public function run()
    {
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
            $profileForm->avatar = UploadedFile::getInstance($profileForm, 'avatar');
            $profileForm->photo = UploadedFile::getInstances($profileForm, 'photo');

            if ($profileForm->validate()) {
                $profileForm->saveProfileData($this->controller->user);

                if ($profileForm->upload()) {
                    PortfolioPhoto::deleteAll(['user_id' => $this->controller->user->id]);
                    foreach ($profileForm->photo as $file) {
                        $portfolioPhoto = new PortfolioPhoto([
                            'photo' => '/uploads/' .  $file,
                            'user_id' => $this->controller->user->id]);
                        $portfolioPhoto->save(false);
                    }
                }
                $session = Yii::$app->session;
                $session->set('city', $this->controller->user->city_id);

                return $this->controller->redirect(['users/view', 'id' => $this->controller->user->id]);
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
