<?php
declare(strict_types = 1);

namespace frontend\models\tasks;

use frontend\models\categories\Categories;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class CreateTaskForm extends Model
{
    public $categories_id;
    public $name;
    public $description;
    public $budget;
    public $expire;
    public $client_id;
    public $file_task;

    private $categories = [];

    public function getCategories(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function rules()
    {

        return [
            ['client_id', 'required'],
            ['name', 'required', 'message' => 'Кратко опишите суть работы'],
            ['description', 'required',
                'message' => 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться'
            ],
          //  ['categories_id', 'required', 'message' => 'Выберите категорию'],
            ['name', 'match', 'pattern' => "/(?=(.*[^ ]){5,})/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 5 не пробельных символов'
            ],
            ['description', 'match', 'pattern' => "/(?=(.*[^ ]){10,})/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            [['categories'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class,
                'targetAttribute' => ['categories_id' => 'id'],
                'message' => 'Такой категории не существует'
            ],
            [['file_task'], 'file', 'extensions' => 'png, jpg'],
            //[['file_'], 'file', 'extensions' => 'png, jpg'],
            ['budget', 'integer', 'min' => 1,
                'tooSmall' => 'Значение должно быть целым положительным числом',
            ],
            ['expire', 'date', 'format' => 'yyyy*MM*dd', 'message' => 'Необходимый формат «гггг.мм.дд»'],
            [['name', 'description', 'categories', 'file_task', 'budget', 'expire'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения',
            'categories' => 'Категория',
            'file_task' => 'Файлы'
        ];
    }
}
