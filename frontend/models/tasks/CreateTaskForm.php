<?php
declare(strict_types = 1);

namespace frontend\models\tasks;

use frontend\models\categories\Categories;

use yii;
use yii\base\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\{BadResponseException, ServerException};
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class CreateTaskForm extends Model
{
    public $name;
    public $description;
    public $budget;
    public $expire;
    public $client_id;
    public $category_id;
    public $status_task;
    public $address;
    public $latitude;
    public $longitude;

    public function getCategories(): array
    {
        return Categories::getCategoriesFilters();
    }

    public function rules(): array
    {
        return [
            ['client_id', 'required'],
            ['name', 'required', 'message' => 'Кратко опишите суть работы'],
            [['name', 'description'], 'trim'],
            ['name', 'match', 'pattern' => "/(?=(.*[^ ]{10,}))/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            ['description', 'required', 'message' => 'Укажите все пожелания и детали, чтобы исполнителю было проще сориентироваться'],
            ['description', 'string', 'min' => 30],
            ['description', 'match', 'pattern' => "/(?=(.*[^ ]))/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 30 не пробельных символов'
            ],
            ['budget', 'integer', 'min' => 1,
                'message' => 'Значение должно быть целым положительным числом',
            ],
            ['category_id', 'validateCat'],
            ['expire', 'validateDate'],
            ['expire', 'date', 'format' => 'yyyy*MM*dd', 'message' => 'Необходимый формат «гггг.мм.дд»'],
            [['client_id', 'name', 'description', 'category_id', 'budget', 'expire', 'status_task', 'address'], 'safe']
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

    public function getCoordinates(string $address): ?array
    {
        $coordinates = null;
        $client = new Client(['base_uri' => 'https://geocode-maps.yandex.ru/']);
        $request = new GuzzleRequest('GET', '1.x');
        $response = $client->send($request, [
            'query' => [
                'geocode' => $address,
                'apikey' => Yii::$app->params['apiKey'],
                'format' => 'json',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new BadResponseException("Ошибка ответа: " . $response->getReasonPhrase(), $request, $response);
        }
        $jsonResponseData = $response->getBody()->getContents();
        $responseData = json_decode($jsonResponseData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ServerException("Некорректный json-формат", $request, $response);
        }
        $error = $responseData['message'] ?? null;

        if ($error) {
            throw new BadResponseException("API ошибка: " . $error, $request, $response);
        }

        if ($responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'] ?? null) {
            $coordinates = explode(' ', $responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
        }

        return $coordinates;
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
            'address' => 'Локация',
        ];
    }
}
