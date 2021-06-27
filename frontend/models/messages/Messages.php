<?php
declare(strict_types = 1);

namespace frontend\models\messages;

use frontend\models\{
    tasks\Tasks,
    users\Users
};

use Yii;

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
class Messages extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'messages';
    }

    public function rules()
    {
        return [
            [['text', 'writer_id', 'task_id'], 'required'],
            [['text'], 'string'],
            [['dt_add'], 'safe'],
            [['writer_id', 'task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['writer_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'dt_add' => 'Dt Add',
            'writer_id' => 'Writer ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getWriter()
    {
        return $this->hasOne(Users::class, ['id' => 'writer_id']);
    }

    public static function find()
    {
        return new MessagesQuery(get_called_class());
    }
}
