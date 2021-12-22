<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use yii\base\Model;

class RefuseForm extends Model
{
    public $task_id;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['task_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'task_id' => 'Задание'
        ];
    }
}
