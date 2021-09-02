<?php
declare(strict_types=1);

namespace frontend\models\messages;

use frontend\models\{
    tasks\Tasks,
    users\Users
};

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $message
 * @property string $published_at
 * @property int $writer_id
 * @property int $task_id
 * @property int $is_mine
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
            [['message', 'task_id'], 'required'],
            [['message'], 'string'],
            [['published_at', 'message', 'writer_id', 'task_id', 'is_mine'], 'safe'],
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
}
