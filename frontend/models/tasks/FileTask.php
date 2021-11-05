<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file_task".
 *
 * @property int $id
 * @property string $file_item
 * @property int $task_id
 *
 * @property Tasks $task
 */
class FileTask extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'file_task';
    }

    public function rules(): array
    {
        return [
            [['file_item', 'task_id'], 'required'],
            [['task_id'], 'integer'],
            [['file_item'], 'string', 'max' => 255],
            [['task_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'file_item' => 'File Item',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public static function find(): FileTaskQuery
    {
        return new FileTaskQuery(get_called_class());
    }
}
