<?php
declare(strict_types=1);

namespace frontend\models\responses;

use yii\base\Model;

class ResponseForm extends Model
{
    public $budget;
    public $comment;
    public $doer_id;
    public $is_refused;
    public $task_id;

    public function rules(): array
    {
        return [
            [['doer_id', 'task_id', 'is_refused'], 'required'],
            [['budget', 'comment'], 'required',
                'message' => 'Это поле должно быть заполнено',
            ],
            ['budget', 'integer', 'min' => 1],
            ['comment', 'string'],
            ['comment', 'trim'],
            [['budget', 'comment', 'doer_id', 'is_refused', 'task_id'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'budget' => 'Ваша цена',
            'comment' => 'Комментарий',
            'doer_id' => 'Исполнитель',
            'is_refused' => 'Отклонено',
            'task_id' => 'Задание',
        ];
    }
}
