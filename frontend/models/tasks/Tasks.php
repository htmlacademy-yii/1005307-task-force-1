<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use frontend\models\{categories\Categories,
    cities\Cities,
    messages\Messages,
    notifications\Notifications,
    opinions\Opinions,
    responses\Responses,
    users\Users
};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $dt_add
 * @property int|null $category_id
 * @property int|null $city_id
 * @property int|null $doer_id
 * @property int $client_id
 * @property string $name
 * @property string $description
 * @property string|null $expire
 * @property string|null $address
 * @property int|null $budget
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $location_comment
 * @property string $status_task
 *
 * @property FileTask[] $fileTasks
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property Responses[] $Responses
 * @property Categories $category
 * @property Cities $city
 * @property Users $client
 * @property Users $doer
 */
class Tasks extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tasks';
    }

    public function rules(): array
    {
        return [
            [['dt_add', 'expire'], 'safe'],
            [['category_id', 'budget', 'city_id', 'doer_id', 'client_id'], 'integer'],
            [['description', 'name', 'client_id'], 'required'],
            [['description'], 'string'],
            [['name', 'address', 'latitude', 'longitude', 'location_comment', 'status_task'], 'string', 'max' => 255],
            [['category_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Categories::class,
                'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Cities::class,
                'targetAttribute' => ['city_id' => 'id']],
            [['client_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['client_id' => 'id']],
            [['doer_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['doer_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'expire' => 'Expire',
            'name' => 'Name',
            'address' => 'Address',
            'budget' => 'Budget',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'location_comment' => 'Location Comment',
            'city_id' => 'City ID',
            'doer_id' => 'Doer ID',
            'client_id' => 'Client ID',
            'status_task' => 'Status Task',
        ];
    }

    public function getFileTasks(): ActiveQuery
    {
        return $this->hasMany(FileTask::class, ['task_id' => 'id']);
    }

    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Responses::class, ['task_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function getCity(): ActiveQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'client_id']);
    }

    public function getDoer(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    public static function find(): TasksQuery
    {
        return new TasksQuery(get_called_class());
    }

    final public static function getLastTasks(): array
    {
        $query = self::find()
            ->andwhere(['status_task' => 'Новое'])
            ->with('category')
            ->with('city')
            ->limit(4)
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->all();
        return $query;
    }

    final public static function getOneTask($id): Tasks
    {
        return self::findOne($id);
    }

    public function nextAction($currentStatus, $role): array
    {
        switch ($currentStatus) {
            case 'Новое':
                return $role == 'doer' ? ['title' => 'response', 'name' => 'Откликнуться', 'data' => 'response'] : '';
            case 'На исполнении':
                return $role == 'doer' ? ['title' => 'refusal', 'name' => 'Отказаться', 'data' => 'refuse'] : ['title' => 'request', 'name' => 'Завершить', 'data' => 'complete'];
        }

        return [];
    }

    public function countUsersTasks($status, $user): string
    {
        switch ($user->user_role) {
            case 'doer':
                return Tasks::find()
                    ->where(['doer_id' => $user->id])
                    ->andWhere(['status_task' => $status])->count();
            case 'client':
                return Tasks::find()
                    ->where(['client_id' => $user->id])
                    ->andWhere(['status_task' => $status])->count();
        }
        return '';
    }
}
