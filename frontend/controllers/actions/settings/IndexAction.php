<?php

declare(strict_types=1);

namespace frontend\controllers\actions\settings;

use frontend\models\account\SettingsForm;
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
    public $settingsForm;

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
        $this->settingsForm = new SettingsForm();
        $request = \Yii::$app->request;
        $user = Users::findOne($this->user->id);

        if (!$this->settingsForm->load($request->post())) {
            $this->settingsForm->loadCurrentUserData($user);
        }
        if ($this->settingsForm->load($request->post())) {
            if ($request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($this->settingsForm);
            }
            if ($this->settingsForm->saveProfileData($user)) {
                $this->uploadFile($user);

                return $this->controller->redirect(['users/view', 'id' => $user->id]);
            }
        }

        return $this->controller->render(
            '/settings/index',
            [
                'user' => $user,
                'settingsForm' => $this->settingsForm,
            ]
        );
    }

    private function uploadFile($user): void
    {
        $request = Yii::$app->request;

        if ($this->settingsForm->load($request->post())) {
            $this->settingsForm->portfolio_photo = UploadedFile::getInstances($this->settingsForm, 'portfolio_photo');

            if (!empty($this->settingsForm->portfolio_photo) && $this->settingsForm->upload()) {
                PortfolioPhoto::deleteAll(['user_id' => $user->id]);
                $files = array();

                foreach ($this->settingsForm->portfolio_photo as $fileItem) {
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
