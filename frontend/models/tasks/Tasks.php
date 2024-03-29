<?php
declare(strict_types=1);

namespace frontend\models\tasks;

use frontend\models\{categories\Categories,
    categories\CategoriesQuery,
    cities\Cities,
    cities\CitiesQuery,
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
 * @property string|null $address
 * @property int|null $budget
 * @property int $category_id
 * @property int|null $city_id
 * @property int $client_id
 * @property string $description
 * @property int|null $doer_id
 * @property string $dt_add
 * @property string|null $expire
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string $name
 * @property int $online
 * @property int $responses_count
 * @property string $status_task
 *
 * @property Categories $category
 * @property Cities $city
 * @property FileTask[] $fileTasks
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property Responses[] $Responses
 * @property Users $client
 * @property Users $doer
 */
class Tasks extends ActiveRecord
{
    private $status_task;
    private $responses_count;
    private $doer_id;
    private $client_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['budget', 'category_id', 'city_id', 'client_id', 'doer_id', 'online', 'responses_count'], 'integer'],
            [['address', 'description', 'dt_add', 'expire', 'latitude', 'longitude', 'name', 'status_task'], 'string', 'max' => 255],
            [['category_id', 'client_id', 'description', 'dt_add', 'name', 'online', 'responses_count', 'status_task'], 'required'],
            [['address', 'budget', 'category_id', 'city_id', 'client_id', 'description', 'doer_id', 'dt_add', 'expire', 'latitude', 'longitude', 'name', 'online', 'responses_count', 'status_task'], 'safe'],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'budget' => 'Budget',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'client_id' => 'Client ID',
            'description' => 'Description',
            'doer_id' => 'Doer ID',
            'dt_add' => 'Dt Add',
            'expire' => 'Expire',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'name' => 'Name',
            'online' => 'Online',
            'responses_count' => 'Responses Count',
            'status_task' => 'Status Task',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Doer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoer(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    /**
     * Gets query for [[FileTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileTasks(): ActiveQuery
    {
        return $this->hasMany(FileTask::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Responses::class, ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find(): TasksQuery
    {
        return new TasksQuery(get_called_class());
    }

    /**
     * Gets one task
     *
     * @param $id
     * @return Tasks
     */
    final public static function getOneTask($id): Tasks
    {
        return self::findOne($id);
    }

    /**
     * Counts user task depending in role and status
     *
     * @param $status
     * @param $user_role
     * @param $user
     * @return string
     */
    public function countUsersTasks($status, $user_role, $user): string
    {
        switch ($user_role) {
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

    /**
     * Get title and name for button in view
     *
     * @param $currentStatus
     * @param $role
     * @return array|string[]
     */
    public function nextAction($currentStatus, $role): array
    {
        switch ($currentStatus) {
            case 'Новое':
                return $role == 'doer' ? ['title' => 'response', 'name' => 'Откликнуться', 'data' => 'response'] : [];
            case 'На исполнении':
                return $role == 'doer' ? ['title' => 'refusal', 'name' => 'Отказаться', 'data' => 'refuse'] : ['title' => 'request', 'name' => 'Завершить', 'data' => 'complete'];
        }

        return [];
    }
}
