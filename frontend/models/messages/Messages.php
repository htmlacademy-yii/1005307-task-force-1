<?php
declare(strict_types = 1);

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
 * @property string $text
 * @property string $dt_add
 * @property int $writer_id
 * @property int $task_id
 *
 * @property Tasks $task
 * @property Users $writer
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
            [['message', 'writer_id', 'task_id'], 'required'],
            [['message'], 'string'],
            [['dt_add'], 'safe'],
            [['writer_id', 'task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['writer_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'dt_add' => 'Dt Add',
            'writer_id' => 'Writer ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getWriter(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'writer_id']);
    }

    public static function find(): MessagesQuery
    {
        return new MessagesQuery(get_called_class());
    }

    public function getMessagesByTask($taskId): array
    {
        return self::find()
            ->where(['task_id' => $taskId])
            ->asArray()->all();
    }
}
