<?php
declare(strict_types=1);

namespace frontend\controllers;

use app\models\account\SignForm;
use app\models\users\Users;

use Yii;
use yii\web\Controller;

class SignController extends Controller
{
    public function beforeAction($action)
    {
        return true;
    }

    public function actionIndex(): string
    {
        $signForm = new SignForm();
        if (Yii::$app->request->getIsPost()) {
            $signForm->load(Yii::$app->request->post());
            if (!$signForm->validate()) {
                $errors = $signForm->getErrors();
            }

            $user = new Users(['attributes' => $signForm->attributes]);
            $user->password = Yii::$app->security->generatePasswordHash($signForm->password);

            if ($signForm->validate()) {
                $user->save(false);
                $this->redirect(['landing/']);
            }

        }
        return $this->render('index', ['signForm' => $signForm]);
    }
}
