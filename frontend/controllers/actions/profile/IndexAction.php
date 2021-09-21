<?php

declare(strict_types=1);

namespace frontend\controllers\actions\profile;

use frontend\models\account\ProfileForm;
use frontend\models\account\PortfolioPhotoForm;
use frontend\models\users\PortfolioPhoto;
use frontend\models\users\Users;
use yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class IndexAction extends Action
{
    public $profileForm;
    public $portfolioPhotoForm;
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
        $this->profileForm = new ProfileForm();
        $this->portfolioPhotoForm = new PortfolioPhotoForm();
        $request = \Yii::$app->request;
        $user = Users::findOne($this->user->id);

        if (!$this->profileForm->load($request->post())) {
            $this->profileForm->loadCurrentUserData($user);
        }

        if ($request->isAjax && $this->profileForm->load($request->post()) && $this->portfolioPhotoForm->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->end();

            return ActiveForm::validateMultiple([$this->profileForm, $this->portfolioPhotoForm]);
        }

        $this->portfolioPhotoForm->photo = UploadedFile::getInstances($this->portfolioPhotoForm, 'photo');

        if ($this->profileForm->load($request->post())) {
            if ($this->profileForm->validate() && $this->portfolioPhotoForm->validate()) {
                $this->profileForm->avatar = UploadedFile::getInstance($this->profileForm, 'avatar');
                $this->profileForm->saveProfileData($user);
                $this->uploadFile($user);

                return $this->controller->redirect(['users/view', 'id' => $user->id]);
            }
        }
        //}

        return $this->controller->render(
            '/profile/index',
            [
                'user' => $user,
                'profileForm' => $this->profileForm,
                'portfolioPhotoForm' => $this->portfolioPhotoForm
            ]
        );
    }

    private function uploadFile($user): void
    {
        $request = Yii::$app->request;
        if ($this->portfolioPhotoForm->load($request->post())) {
            $this->portfolioPhotoForm->photo = UploadedFile::getInstances($this->portfolioPhotoForm, 'photo');
            PortfolioPhoto::deleteAll(['user_id' => $user->id]);
            $files = array();

            foreach ($this->portfolioPhotoForm->photo as $fileItem) {
                $files[] = [$fileItem, $user->id];
            }

            Yii::$app->db->createCommand()
                ->batchInsert('portfolio_photo',
                    ['photo', 'user_id'],
                    $files)
                ->execute();
            return;
        }
    }
}
