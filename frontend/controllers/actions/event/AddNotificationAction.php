<?php

declare(strict_types=1);

namespace frontend\controllers\actions\event;

use frontend\models\notifications\Notifications;
use frontend\models\tasks\Tasks;
use frontend\models\users\UserOptionSettings;
use frontend\models\users\Users;
use yii\base\Action;
use Yii;

class AddNotificationAction extends Action
{
    public function run($task_id, $notification_category, $user_id, $settings)
    {
        $notification = new Notifications();
        $notification->notification_category_id = $notification_category;
        $notification->task_id = $task_id;
        $notification->visible = 1;
        $notification->user_id = $user_id;
        $notification->save();

        $user = Users::findOne($user_id);
        $user_set = UserOptionSettings::findOne($user->id);
        $email = $user->email;
        $subject = $notification['notificationsCategory']['name'];
        $task = Tasks::findOne($task_id);
        if($user_set->$settings == 1) {
            Yii::$app->mailer->compose()
                ->setFrom('login@gmail.com')
                ->setTo($email)
                ->setSubject($subject)
                ->setHtmlBody('У вас новое уведомление:' . $subject . '<a href="#">' . $task->name . '</a>')
                ->send();
        }
    }
}
