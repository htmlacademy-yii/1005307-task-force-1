<?php
declare(strict_types = 1);

namespace frontend\models\tasks;

use frontend\models\categories\Categories;

use yii;
use yii\base\Model;

class CreateTaskForm extends Model
{
    public $name;
    public $description;
    public $budget;
    public $expire;
    public $client_id;
    public $category_id;

    public function getCategories(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function rules(): array
    {
        return [
            ['client_id', 'required'],
            ['name', 'required', 'message' => 'Кратко опишите суть работы'],
            ['name', 'match', 'pattern' => "/(?=(.*[^ ]){5,})/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 5 не пробельных символов'
            ],
            ['description', 'required', 'message' => 'Укажите все пожелания и детали, чтобы исполнителю было проще сориентироваться'],
            ['description', 'match', 'pattern' => "/(?=(.*[^ ]){10,})/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            ['budget', 'integer', 'min' => 1,
                'tooSmall' => 'Значение должно быть целым положительным числом',
            ],
            ['expire', 'validateDate'],
            ['category_id', 'required'],
            ['category_id', 'validateCat'],
            ['expire', 'date', 'format' => 'yyyy*MM*dd', 'message' => 'Необходимый формат «гггг.мм.дд»'],

            [['client_id', 'name', 'description', 'category_id', 'budget', 'expire'], 'safe']

        ];
    }

    public function validateCat() {
        if ($this->category_id == 0) {
            $this->addError('category_id', 'Выберите категорию');
        }
    }

    public function validateDate() {
        $currentDate = date('Y-m-d H:i:s');

        if ($currentDate > $this->expire) {
            $this->addError('expire', '"Срок исполнения", не может быть раньше текущей даты');
        }
    }

    public function attributeLabels(): array
    {
        return [
            'client_id' => 'Заказчик',
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения',
            'category_id' => 'Категория',
        ];
    }
}
