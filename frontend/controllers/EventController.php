<?php

namespace frontend\controllers;


use frontend\models\notifications\Notifications;
use frontend\models\tasks\Tasks;
use Yii;
use yii\web\Controller;
use yii\web\View;

class EventController extends Controller
{
    public function actionIndex()
    {
        return json_encode(Notifications::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all(), JSON_UNESCAPED_UNICODE);
    }

    public function actionDisable($id)
    {
        if (Yii::$app->request->isPost) {
            $notice = Notifications::find()->where(['id' => $id])->one();
            return $notice->disable();
        }

        return Yii::$app->response->redirect('/');
    }
}
