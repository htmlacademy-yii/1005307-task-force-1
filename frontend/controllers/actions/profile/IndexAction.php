<?php

declare(strict_types=1);

namespace frontend\controllers\actions\profile;

use frontend\models\{
    account\ProfileForm,
    users\PortfolioPhoto,
    users\Users
};

use yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\UploadedFile;
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
        $profileForm = new ProfileForm();
        $request = \Yii::$app->request;
        $user = Users::findOne($this->user->id);

        if (!$profileForm->load($request->post())) {
            $profileForm->loadCurrentUserData($user);
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
                if ($profileForm->upload()) {
                    PortfolioPhoto::deleteAll(['user_id' => $user->id]);

                    foreach ($profileForm->photo as $photo) {
                        $portfolioPhoto = new PortfolioPhoto([
                            'photo' => $photo,
                            'user_id' => $user->id]);
                        $portfolioPhoto->save(false);
                    }
                }

                $profileForm->saveProfileData($user);

                return $this->controller->redirect(['users/view', 'id' => $user->id]);
            }
        }

        return $this->controller->render(
            '/profile/index',
            [
                'user' => $user,
                'profileForm' => $profileForm,
            ]
        );
    }
}
