<?php
declare(strict_types = 1);

namespace frontend\models\task_actions;

use yii;
use yii\base\Model;

class ResponseForm extends Model
{
    public $doer_id;
    public $task_id;
    public $budget;
    public $description;

    public function rules(): array
    {
        return [
            ['doer_id', 'required'],
            ['task_id', 'required'],
            [['budget', 'description'], 'trim'],
            [['budget', 'description'], 'required',
                'message' => 'Это поле должно быть заполнено',
            ],
            ['budget', 'integer', 'min' => 1,
                'message' => 'Значение должно быть целым положительным числом',
            ],
            ['description', 'trim'],
            ['description', 'match', 'pattern' => "/(?=(.*[^ ]{10,}))/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            [['doer_id', 'task_id', 'budget', 'description'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'doer_id' => 'Исполнитель',
            'task_id' => 'Задание',
            'budget' => 'Ваша цена',
            'description' => 'Комментарий',
        ];
    }
}
