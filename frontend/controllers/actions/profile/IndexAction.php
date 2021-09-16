<?php

declare(strict_types=1);

namespace frontend\controllers\actions\profile;

use frontend\models\account\ProfileForm;
use frontend\models\opinions\Opinions;
use frontend\models\tasks\Tasks;
use frontend\models\users\PortfolioPhoto;
use frontend\models\users\Users;
use yii\base\Action;
use yii\base\BaseObject;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii;
use yii\web\UploadedFile;

class IndexAction extends Action
{
    public $profileForm;

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
        $request = \Yii::$app->request;
        $user = Users::findOne($this->user->id);

        if (!$this->profileForm->load($request->post())) {
            $this->profileForm->loadCurrentUserData($user);
        }
        if ($this->profileForm->load($request->post())) {
            if ($request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($this->profileForm);
            }
            if ($this->profileForm->validate()) {
                $this->profileForm->saveProfileData($user);
                $this->uploadFile($user);

                return $this->controller->redirect(['users/view', 'id' => $user->id]);
            }
        }

        return $this->controller->render(
            '/profile/index',
            [
                'user' => $user,
                'profileForm' => $this->profileForm,
            ]
        );
    }

    private function uploadFile($user): void
    {
        $request = Yii::$app->request;

        if ($this->profileForm->load($request->post())) {
            $this->profileForm->portfolio_photo = UploadedFile::getInstances($this->profileForm, 'portfolio_photo');

            if (!empty($this->profileForm->portfolio_photo) && $this->profileForm->upload()) {
                PortfolioPhoto::deleteAll(['user_id' => $user->id]);
                $files = array();

                foreach ($this->profileForm->portfolio_photo as $fileItem) {
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
}
