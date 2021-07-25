<?php

declare(strict_types=1);

namespace frontend\controllers\actions\sign;
use yii\base\Action;

use frontend\models\account\SignForm;
use frontend\models\users\Users;

use Yii;

class IndexAction extends Action
{
    public function run(): string
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
                $this->controller->goHome();
            }
        }

        return $this->controller->render('index', ['signForm' => $signForm]);
    }
}
