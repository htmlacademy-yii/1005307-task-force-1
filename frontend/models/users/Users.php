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
 * @property string|null $about
 * @property string|null $address
 * @property string|null $avatar
 * @property string|null $birthday
 * @property int $city_id
 * @property int $created_tasks
 * @property int $done_tasks
 * @property string $dt_add
 * @property string $email
 * @property int $failed_tasks
 * @property string $last_activity_time
 * @property string $name
 * @property int $opinions_count
 * @property string $password
 * @property string|null $phone
 * @property float|null $rating
 * @property string|null $skype
 * @property string|null $telegram
 * @property string $user_role
 * @property string|null $vk_id
 *
 * @property Cities $city
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
            'about' => 'About',
            'address' => 'Address',
            'avatar' => 'Avatar',
            'bd' => 'Bd',
            'city_id' => 'City ID',
            'created_tasks' => 'Created Tasks',
            'done_tasks' => 'Done Tasks',
            'dt_add' => 'Dt Add',
            'email' => 'Email',
            'failed_tasks' => 'Failed Tasks',
            'last_activity_time' => 'Last Activity Time',
            'name' => 'Name',
            'password' => 'Password',
            'opinions_count' => 'Opinions Count',
            'phone' => 'Phone',
            'rating' => 'Rating',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'user_role' => 'User Role',
        ];
    }

    public function getCity(): ActiveQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    public function getFavourites(): ActiveQuery
    {
        return $this->hasMany(Favourites::class, ['favourite_person_id' => 'id']);
    }

    public function getOpinions(): ActiveQuery
    {
        return $this->hasMany(Opinions::class, ['doer_id' => 'id']);
    }

    public function getOptionSet(): ActiveQuery
    {
        return $this->hasOne(UserOptionSettings::class, ['user_id' => 'id']);
    }

    public function getPortfolioPhotos(): ActiveQuery
    {
        return $this->hasMany(PortfolioPhoto::class, ['user_id' => 'id']);
    }

    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
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
