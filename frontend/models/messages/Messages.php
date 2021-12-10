<?php
declare(strict_types=1);

namespace frontend\models\messages;

use frontend\models\{
    tasks\Tasks,
    users\Users
};

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
    private $writer_id;

    public static function tableName(): string
    {
        return 'messages';
    }

    public function rules(): array
    {
        return [
            [['message', 'task_id', 'unread'], 'required'],
            [['message'], 'string'],
            [['is_mine', 'message', 'published_at', 'recipient_id', 'task_id', 'unread', 'writer_id'], 'safe'],
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
            'writer_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'message',
            'published_at',
            'writer_id',
            'task_id',
            'is_mine',
            'unread',
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

    public static function getUserMessages($task_id, $user_id): array
    {
        return self::find()->where(['task_id' => $task_id])
            ->andWhere(['recipient_id' => $user_id])
            ->andWhere(['unread' => 1])->asArray()->all();
    }

    public static function find(): MessagesQuery
    {
        return new MessagesQuery(get_called_class());
    }
}
