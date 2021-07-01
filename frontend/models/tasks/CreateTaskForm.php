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

    public $categories;

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
      //      ['categories', 'required',  'message' => 'Выберите категорию'],
            [
                'categories', 'exist', 'skipOnError' => false,
                'targetClass' => Categories::class, 'targetAttribute' => ['categories' => 'id'],
                'message' => 'Такой категории не существует'
            ],
            ['budget', 'integer', 'min' => 1,
                'tooSmall' => 'Значение должно быть целым положительным числом',
            ],
            ['expire', 'validateDate'],
            ['expire', 'date', 'format' => 'yyyy*MM*dd', 'message' => 'Необходимый формат «гггг.мм.дд»'],
            [['client_id', 'name', 'description', 'categories', 'budget', 'expire'], 'safe']
        ];
    }

    /**
     * @throws yii\base\InvalidConfigException
     */
    public function validateDate() {
        $currentDate = Yii::$app->getFormatter()->asDate(time());

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
            'categories' => 'Категория',
        ];
    }
}
