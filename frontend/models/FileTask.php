<?php

namespace app\models;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_item', 'task_id'], 'required'],
            [['task_id'], 'integer'],
            [['file_item'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_item' => 'File Item',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
