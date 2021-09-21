<?php
declare(strict_types = 1);

namespace frontend\models\notifications;

use frontend\models\{
    tasks\Tasks,
    users\Users
};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property string $notification_category_id
 * @property int $visible
 * @property string $dt_add
 *
 * @property Tasks $task
 * @property Users $user
 * @property NotificationsCategories $notificationsCategory
 */

class Notifications extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'notifications';
    }

    public function rules(): array
    {
        return [
            [['visible', 'notification_category_id', 'user_id', 'task_id'], 'required'],
            [['visible', 'notification_category_id', 'user_id', 'task_id'], 'integer'],
            [['dt_add'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['notification_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationsCategories::class, 'targetAttribute' => ['notification_category_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'is_view' => 'Is View',
            'dt_add' => 'Dt Add',
            'type' => 'Type',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getNotificationsCategory(): ActiveQuery
    {
        return $this->hasOne(NotificationsCategories::class, ['id' => 'notification_category_id']);
    }

    public static function find(): NotificationsQuery
    {
        return new NotificationsQuery(get_called_class());
    }

    public function getNotifications($user_id): NotificationsQuery
    {
        return self::find()->where(['user_id' => $user_id]);
    }

    public static function getVisibleNoticesByUser($id): array
    {
        return self::find()
            ->where([
                'visible' => 0,
                'user_id' => $id
            ])->all();
    }
}
