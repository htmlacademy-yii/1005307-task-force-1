<?php
declare(strict_types=1);

namespace frontend\models\opinions;

use yii\base\Model;

class RequestForm extends Model
{
    public $client_id;
    public $completion;
    public $description;
    public $doer_id;
    public $rate;
    public $task_id;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['doer_id', 'client_id', 'task_id'], 'required'],
            [['completion'], 'required',
                'message' => "Сообщите выполнено ли задание"],
            [['doer_id', 'client_id', 'task_id', 'completion', 'description', 'rate'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'client_id' => 'Заказчик',
            'description' => 'Комментарий',
            'doer_id' => 'Исполнитель',
            'rate' => 'Оценка',
            'task_id' => 'Задание',
        ];
    }
}
