<?php
declare(strict_types=1);

namespace frontend\models\tasks;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'file_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['task_id'], 'integer'],
            [['file_item'], 'string', 'max' => 255],
            [['file_item', 'task_id'], 'required'],
            [['file_item', 'task_id'], 'safe'],
            [['task_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'file_item' => 'File Item',
            'task_id' => 'Task ID',
        ];
    }
}
