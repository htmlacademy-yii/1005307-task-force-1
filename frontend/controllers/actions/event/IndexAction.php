<?php

declare(strict_types=1);

namespace frontend\controllers\actions\event;

use frontend\models\notifications\Notifications;
use frontend\models\tasks\Tasks;
use Yii;
use yii\web\Controller;
use yii\web\View;

class IndexAction
{
    public function run()
    {
        return json_encode(Notifications::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all(), JSON_UNESCAPED_UNICODE);
    }
}
