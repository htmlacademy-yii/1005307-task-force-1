<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use frontend\models\{categories\Categories};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\{BadResponseException, ServerException};
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use yii;
use yii\base\Model;
use yii\web\UploadedFile;

class CreateTaskForm extends Model
{
    public $address;
    public $budget;
    public $category_id;
    public $city_id;
    public $client_id;
    public $description;
    public $expire;
    public $file_item;
    public $latitude;
    public $longitude;
    public $name;
    public $online;
    public $status_task;
    private $coordinates;

    public function rules(): array
    {
        return [
            ['client_id', 'required'],
            ['name', 'required',
                'message' => 'Кратко опишите суть работы'],
            [['name', 'description'], 'trim'],
            ['name', 'string', 'min' => 10,
                'message' => 'Длина поля «{attribute}» должна быть не меньше 10 не пробельных символов'
            ],
            ['description', 'required',
                'message' => 'Укажите все пожелания и детали, чтобы исполнителю было проще сориентироваться'],
            ['description', 'string', 'min' => 30],
            ['description', 'match',
                'pattern' => "/(?=(.*[^ ]))/",
                'message' => 'Длина поля «{attribute}» должна быть не меньше 30 не пробельных символов'
            ],
            [['file_item'], 'file',
                'skipOnEmpty' => true],
            ['budget', 'integer',
                'min' => 1,
                'message' => 'Значение должно быть целым положительным числом',
            ],
            [['category_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Categories::class,
                'targetAttribute' => ['category_id' => 'id'],
                'message' => "Выбрана несуществующая категория"
            ],
            ['expire', 'date', 'when' => function ($model) {
                return strtotime($model->expire) < time();
            }, 'message' => 'Срок исполнения должен быть больще текущей даты'],
            [['client_id', 'name', 'description', 'category_id', 'budget', 'expire', 'online', 'status_task', 'address', 'file_item'], 'safe']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'category_id' => 'Категория',
            'client_id' => 'Заказчик',
            'description' => 'Подробности задания',
            'expire' => 'Срок исполнения',
            'name' => 'Мне нужно',
        ];
    }

    public function getAddress(): void
    {
        $session = Yii::$app->session;
        $this->online = 1;
        if ($this->address ?? null) {
            $this->coordinates = $this->getCoordinates($this->address);
            $this->longitude = $this->coordinates[0] ?? null;
            $this->latitude = $this->coordinates[1] ?? null;
            $this->city_id = $session->get('city');
            $this->address = explode (' ', $this->address, 3);
            $this->address = $this->address[2];
            $this->online = 0;
        }
    }

    public function upload(): bool
    {
        if (!empty($this->file_item)) {
            $this->file_item = UploadedFile::getInstances($this, 'file_item');
            if ($this->validate()) {
                foreach ($this->file_item as $file) {
                    $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                }
            }
            return true;
        }

        return false;
    }

    private function getGeoData(string $address): ?array
    {
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

        return $responseData;
    }

    private function getCoordinates($address): array
    {
        $this->coordinates = null;
        $responseData = $this->getGeoData($address);

        if ($responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'] ?? null) {
            $this->coordinates = explode(' ', $responseData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
        }

        return $this->coordinates;
    }
}
