<?php
declare(strict_types=1);

namespace frontend\models\notifications;

use frontend\models\{tasks\Tasks, users\Users};
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property string $dt_add
 * @property string $notification_category_id
 * @property int $task_id
 * @property int $user_id
 * @property int $visible
 *
 * @property NotificationsCategories $notificationsCategory
 * @property Tasks $task
 * @property Users $user
 */
class Notifications extends ActiveRecord
{
    public $subject;
    private $visible;

    public static function tableName(): string
    {
        return 'notifications';
    }

    public function rules(): array
    {
        return [
            [['notification_category_id', 'task_id', 'user_id', 'visible'], 'integer'],
            [['notification_category_id', 'task_id', 'user_id', 'visible'], 'required'],
            [['dt_add'], 'safe'],
            [['notification_category_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => NotificationsCategories::class,
                'targetAttribute' => ['notification_category_id' => 'id']],
            [['task_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'notification_category_id' => 'Notification Category Id',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'visible' => 'Visible',
        ];
    }

    public function getNotificationsCategory(): ActiveQuery
    {
        return $this->hasOne(NotificationsCategories::class, ['id' => 'notification_category_id']);
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function addNotification(): void
    {
        $user = Users::findOne($this->user_id);
        $task = Tasks::findOne($this->task_id);
        $subject = $this['notificationsCategory']['name'];
        Yii::$app->mailer->compose('@frontend/views/site/email', ['user' => $user, 'subject' => $subject, 'task' => $task])
            ->setTo($user->email)
            ->setFrom('smtp.mailtrap.io')
            ->setSubject($subject)
            ->send();
    }

    public static function getVisibleNoticesByUser($id): array
    {
        $query = self::find()
            ->where([
                'visible' => 1,
                'user_id' => $id
            ]);

        return $query->all();
    }
}
