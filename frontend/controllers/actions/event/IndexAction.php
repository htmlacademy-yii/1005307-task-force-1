<?php

declare(strict_types=1);

namespace frontend\controllers\actions\event;

use frontend\models\notifications\Notifications;
use yii\base\Action;
use yii\web\View;

class IndexAction extends Action
{
    public function run(View $view)
    {
        $user = \Yii::$app->user->getIdentity();
        $notification = new Notifications();
        $notifications = $notification->getVisibleNoticesByUser($user->id);
        $view->params['newEvents'] = $notifications;

        if ($view->params['newEvents']) {
            if (property_exists($notification, 'visible')) {
                foreach ($view->params['newEvents'] as $event) {
                    $event->visible = 0;
                    $event->save(false);
                }
            }
        }
    }
}
