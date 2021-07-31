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
    public $comment;
    public $is_refused;

    public function rules(): array
    {
        return [
            [['doer_id', 'task_id', 'is_refused'], 'required'],
            [['budget', 'comment'], 'required',
                'message' => 'Это поле должно быть заполнено',
            ],
            ['budget', 'integer', 'min' => 1,
                'message' => 'Значение должно быть целым положительным числом',
            ],
            [['comment'], 'string', 'min' => 10],
            ['comment', 'trim'],
            [['doer_id', 'task_id', 'budget', 'comment', 'is_refused'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'doer_id' => 'Исполнитель',
            'task_id' => 'Задание',
            'is_refused' => 'Отклонено',
            'budget' => 'Ваша цена',
            'comment' => 'Комментарий',
        ];
    }
}
