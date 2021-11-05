<?php
declare(strict_types=1);

namespace frontend\models\users;

use frontend\models\{categories\Categories,
    cities\Cities,
    messages\Messages,
    notifications\Notifications,
    opinions\Opinions,
    responses\Responses,
    tasks\Tasks
};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $vk_id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $dt_add
 * @property string $user_role
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $avatar
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int $city_id
 * @property int $failed_tasks
 * @property int $done_tasks
 * @property int $created_tasks
 * @property int $opinions_count
 * @property string $last_activity_time
 * @property float|null $rating
 *
 * @property Favourites[] $favourites
 * @property Favourites[] $favourites0
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property Opinions[] $opinions0
 * @property PortfolioPhoto[] $portfolioPhotos
 * @property Responses[] $responses
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategory[] $userCategories
 * @property Cities $city
 */
class Users extends ActiveRecord
{
    const SCENARIO_UPDATE = 'update';

    public static function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return [
            [['email', 'name', 'password', 'user_role'], 'required'],
            [['dt_add', 'vk_id', 'bd', 'last_activity_time', 'rating', 'failed_tasks', 'done_tasks', 'created_tasks', 'opinions_count'], 'safe'],
            [['name', 'email', 'password', 'about', 'city_id', 'bd', 'avatar', 'phone', 'skype', 'telegram'], 'safe',
                'on' => self::SCENARIO_UPDATE],
            [['about'], 'string'],
            [['city_id', 'failed_tasks', 'done_tasks', 'created_tasks', 'opinions_count'], 'integer'],
            [['email', 'name', 'password', 'user_role', 'address', 'avatar', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['name'], 'unique'],
            [['city_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Cities::class,
                'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'dt_add' => 'Dt Add',
            'user_role' => 'User Role',
            'address' => 'Address',
            'bd' => 'Bd',
            'avatar' => 'Avatar',
            'rating' => 'Rating',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'city_id' => 'City ID',
            'last_activity_time' => 'Last Activity Time',
            'failed_tasks' => 'Failed Tasks',
            'done_tasks' => 'Done Tasks',
            'created_tasks' => 'Created Tasks',
            'opinions_count' => 'Opinions Count'
        ];
    }

    public function getFavourites(): ActiveQuery
    {
        return $this->hasMany(Favourites::class, ['favourite_person_id' => 'id']);
    }

    public function getFavourites0(): ActiveQuery
    {
        return $this->hasMany(Favourites::class, ['user_id' => 'id']);
    }

    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Messages::class, ['users_id' => 'id']);
    }

    public function getNotifications(): ActiveQuery
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    public function getOpinions(): ActiveQuery
    {
        return $this->hasMany(Opinions::class, ['doer_id' => 'id']);
    }

    public function getOpinions0(): ActiveQuery
    {
        return $this->hasMany(Opinions::class, ['client_id' => 'id']);
    }

    public function getPortfolioPhotos(): ActiveQuery
    {
        return $this->hasMany(PortfolioPhoto::class, ['user_id' => 'id']);
    }

    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Responses::class, ['doer_id' => 'id']);
    }

    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['client_id' => 'id']);
    }

    public function getTasksDoer(): ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['doer_id' => 'id'])->andWhere(['status_task' => 'Выполнено']);
    }

    public function getTasksClient(): ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['client_id' => 'id'])->andWhere(['status_task' => 'Выполнено']);
    }

    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }

    public function getCity(): ActiveQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    public function getOptionSet(): ActiveQuery
    {
        return $this->hasOne(UserOptionSettings::class, ['user_id' => 'id']);
    }

    public static function find(): UsersQuery
    {
        return new UsersQuery(get_called_class());
    }

    final public static function getOneUser($id): Users
    {
        return self::findOne($id);
    }

    public function findModel(): Users
    {
        return self::findOne(\Yii::$app->user->identity->getId());
    }
}
