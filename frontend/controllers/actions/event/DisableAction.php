<?php

declare(strict_types=1);

namespace frontend\controllers\actions\event;

use frontend\models\notifications\Notifications;
use Yii;

class DisableAction
{
    public function run()
    {
        if (Yii::$app->request->isPost) {
            $notice = Notifications::find()->where(['id' => $id])->one();
            return $notice->disable();
        }

        return Yii::$app->response->redirect('/');
    }
}
