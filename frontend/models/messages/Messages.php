<?php
declare(strict_types=1);

namespace frontend\models\messages;

use frontend\models\{
    tasks\Tasks,
    users\Users
};
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $message
 * @property string $published_at
 * @property int $user_id
 * @property int $task_id
 *
 * @property Tasks $task
 * @property Users $user
 */
class Messages extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'messages';
    }

    public function rules(): array
    {
        return [
            [['message', 'user_id', 'task_id'], 'required'],
            [['message'], 'string'],
            [['published_at'], 'safe'],
            [['user_id', 'task_id'], 'integer'],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
            [['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'published_at' => 'Published At',
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

    public static function find(): MessagesQuery
    {
        return new MessagesQuery(get_called_class());
    }
}
