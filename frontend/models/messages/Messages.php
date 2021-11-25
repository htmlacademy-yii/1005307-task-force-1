<?php
declare(strict_types=1);

namespace frontend\models\messages;

use frontend\models\{tasks\Tasks, users\Users};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $is_mine
 * @property string $message
 * @property string $published_at
 * @property int $recipient_id
 * @property int $task_id
 * @property int $unread
 * @property int $writer_id
 */
class Messages extends ActiveRecord
{
    public $is_mine;

    public static function tableName(): string
    {
        return 'messages';
    }

    public function rules(): array
    {
        return [
            [['message', 'task_id', 'unread'], 'required'],
            [['message'], 'string'],
            [['published_at', 'message', 'writer_id', 'recipient_id', 'task_id', 'is_mine', 'unread'], 'safe'],
            [['writer_id', 'task_id'], 'integer'],
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
            [['writer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['writer_id' => 'id']],
            [['recipient_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'published_at' => 'Published At',
            'task_id' => 'Task ID',
            'writer_id' => 'User ID',
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'is_mine',
            'message',
            'published_at',
            'task_id',
            'unread',
            'writer_id',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'writer_id']);
    }

    public static function find(): MessagesQuery
    {
        return new MessagesQuery(get_called_class());
    }

    public static function getUserMessages($task_id, $user_id): array
    {
        return self::find()->where(['task_id' => $task_id])
            ->andWhere(['recipient_id' => $user_id])
            ->andWhere(['unread' => 1])->asArray()->all();
    }
}
