<?php

namespace app\models\notifications;

use Yii;
use app\models\{
    tasks\Tasks,
    users\Users
};

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property string $title
 * @property int $is_view
 * @property string $dt_add
 * @property string $type
 * @property int $user_id
 * @property int $task_id
 *
 * @property Tasks $task
 * @property Users $user
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'is_view', 'type', 'user_id', 'task_id'], 'required'],
            [['is_view', 'user_id', 'task_id'], 'integer'],
            [['dt_add'], 'safe'],
            [['title', 'type'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'is_view' => 'Is View',
            'dt_add' => 'Dt Add',
            'type' => 'Type',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return NotificationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationsQuery(get_called_class());
    }
}
