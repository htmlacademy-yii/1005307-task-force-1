<?php

namespace app\models\users;

use Yii;
use app\models\{
    cities\Cities,
    cities\CitiesQuery,
    categories\Categories,
    messages\Messages,
    messages\MessagesQuery,
    notifications\Notifications,
    notifications\NotificationsQuery,
    opinions\Opinions,
    opinions\OpinionsQuery,
    replies\Replies,
    replies\RepliesQuery,
    tasks\Tasks,
    tasks\TasksQuery
};

/**
 * This is the model class for table "users".
 *
 * @property int $id
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
 * @property int|null $city_id
 * @property string $last_activity_time
 *
 * @property Favourites[] $favourites
 * @property Favourites[] $favourites0
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property Opinions[] $opinions0
 * @property PortfolioPhoto[] $portfolioPhotos
 * @property Replies[] $replies
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategory[] $userCategories
 * @property Cities $city
 */
class Users extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['email', 'name', 'password', 'user_role'], 'required'],
            [['dt_add', 'bd', 'last_activity_time'], 'safe'],
            [['about'], 'string'],
            [['city_id'], 'integer'],
            [['email', 'name', 'password', 'user_role', 'address', 'avatar', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['name'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    public function attributeLabels()
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
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'city_id' => 'City ID',
            'last_activity_time' => 'Last Activity Time',
        ];
    }

    public function getFavourites()
    {
        return $this->hasMany(Favourites::class, ['favourite_person_id' => 'id']);
    }

    public function getFavourites0()
    {
        return $this->hasMany(Favourites::class, ['user_id' => 'id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['writer_id' => 'id']);
    }

    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    public function getOpinions()
    {
        return $this->hasMany(Opinions::class, ['about_id' => 'id']);
    }

    public function getOpinions0()
    {
        return $this->hasMany(Opinions::class, ['writer_id' => 'id']);
    }

    public function getPortfolioPhotos()
    {
        return $this->hasMany(PortfolioPhoto::class, ['user_id' => 'id']);
    }

    public function getReplies()
    {
        return $this->hasMany(Replies::class, ['doer_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['client_id' => 'id']);
    }

    public function getTasks0()
    {
        return $this->hasMany(Tasks::class, ['doer_id' => 'id']);
    }

    public function getUserCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }

    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    final public static function getDoersByFilters(UserSearchForm $form): ?array
    {
        $query = self::find()
    //        ->joinWith('opinions')
            ->select([
                'users.*',
     //           'AVG(opinions.rate) as rating',
    //            'count(opinions.rate) as finished_task_count',
    //            'count(opinions.description) as opinions_count',
            ])
            ->where(['user_role' => 'doer'])
            ->with('userCategories')
            ->with('tasks')
            ->groupBy('users.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray();

        if ($form->searchedCategories) {
            $query->categoriesFilter($form->searchedCategories);
        }

        if ($form->hasOpinions) {
            $query->withOpinionsFilter(0);
        }
        if ($form->isFreeNow) {
            $query->isFreeNowFilter();
        }

        if ($form->isOnlineNow) {
            $query->isOnlineNowFilter();
        }

        if ($form->searchName) {
            $query->nameSearch($form->searchName);
        }

        if ($form->isFavourite) {
            $query->isFavouriteFilter();
        }

        return $query->all();
    }
}
