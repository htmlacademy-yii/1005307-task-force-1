<?php
declare(strict_types = 1);

namespace frontend\models\task_actions;

use yii;
use yii\base\Model;

class CompleteForm extends Model
{
    public $doer_id;
    public $task_id;
    public $client_id;
    public $budget;
    public $description;
    public $completion;

    public function rules(): array
    {
        return [
            [['doer_id', 'client_id', 'task_id'], 'required'],
            [['completion'], 'required', 'message' => "Сообщите выполнено ли задание"],
            [['description'], 'required', 'message' => "Напишите ваще мнение о выполнении задания"],
            [['doer_id', 'client_id', 'task_id', 'completion', 'description'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'doer_id' => 'Исполнитель',
            'client_id' => 'Заказчик',
            'task_id' => 'Задание',
            'description' => 'Комментарий',
        ];
    }
}
