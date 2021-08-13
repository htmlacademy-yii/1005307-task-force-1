<?php
declare(strict_types = 1);

namespace frontend\models\opinions;

use yii;
use yii\base\Model;

class RequestForm extends Model
{
    public $doer_id;
    public $client_id;
    public $task_id;
    public $description;
    public $completion;
    public $rate;

    public function rules(): array
    {
        return [
            [['doer_id', 'client_id', 'task_id'], 'required'],
            [['completion'], 'required', 'message' => "Сообщите выполнено ли задание"],
            [['description'], 'required', 'message' => "Напишите ваще мнение о выполнении задания"],
            [['doer_id', 'client_id', 'task_id', 'completion', 'description', 'rate'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'doer_id' => 'Исполнитель',
            'client_id' => 'Заказчик',
            'task_id' => 'Задание',
            'description' => 'Комментарий',
            'rate' => 'Оценка'
        ];
    }
}
