<?php

declare(strict_types=1);

namespace frontend\controllers\actions\event;

use frontend\models\notifications\Notifications;
use yii\base\Action;

class AddNotificationAction extends Action
{
    public function run($task_id, $notification_category, $user_id)
    {
        $notification = new Notifications();
        $notification->notification_category_id = $notification_category;
        $notification->task_id = $task_id;
        $notification->visible = 1;
        $notification->user_id = $user_id;
        $notification->save();
    }
}
