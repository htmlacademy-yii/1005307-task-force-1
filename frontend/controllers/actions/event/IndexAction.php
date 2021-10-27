<?php

declare(strict_types=1);

namespace frontend\controllers\actions\event;

use frontend\models\notifications\Notifications;
use frontend\models\tasks\Tasks;
use Yii;
use yii\base\Action;
use yii\web\Controller;
use yii\web\View;

class IndexAction extends Action
{
    public function run(View $view)
    {
        $user = \Yii::$app->user->getIdentity();
        $notifications = Notifications::getVisibleNoticesByUser($user);
        $view->params['newEvents'] = $notifications;
        if ($view->params['newEvents']) {

            foreach ($view->params['newEvents'] as $event) {
                $event->visible = 0;
                $event->save();
            }
        }
    }
}
