<?php

namespace frontend\models\tasks;

use Yii;

/**
 * This is the model class for table "file_task".
 *
 * @property int $id
 * @property string $file_item
 * @property int $task_id
 *
 * @property Tasks $task
 */

class FileTask extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'file_task';
    }

    public function rules()
    {
        return [
            [['file_item', 'task_id'], 'required'],
            [['task_id'], 'integer'],
            [['file_item'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_item' => 'File Item',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public static function find()
    {
        return new FileTaskQuery(get_called_class());
    }
}
