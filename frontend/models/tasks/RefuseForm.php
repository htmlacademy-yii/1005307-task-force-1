<?php
declare(strict_types = 1);

namespace frontend\models\tasks;

use yii\base\Model;

class RefuseForm extends Model
{
    public $task_id;

    public function rules(): array
    {
        return [
            [['task_id'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'task_id' => 'Задание'
        ];
    }
}
