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
 * @property int $user_role_id
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $avatar
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property float|null $rate
 * @property int|null $city_id
 * @property string $last_activity_time
 * @property int $finished_task_count
 * @property int $opinions_count
 *
 * @property Favourites[] $favourites
 * @property Favourites[] $favourites0
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property PortfolioPhoto[] $portfolioPhotos
 * @property Replies[] $replies
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategory[] $userCategories
 * @property Cities $city
 * @property UserRole $userRole
 * @property Categories[] $categories
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'user_role_id', 'last_activity_time', 'finished_task_count', 'opinions_count'], 'required'],
            [['dt_add', 'bd', 'last_activity_time'], 'safe'],
            [['user_role_id', 'city_id', 'finished_task_count', 'opinions_count'], 'integer'],
            [['about'], 'string'],
            [['rate'], 'number'],
            [['email', 'name', 'password', 'address', 'avatar', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['name'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['user_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::className(), 'targetAttribute' => ['user_role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'dt_add' => 'Dt Add',
            'user_role_id' => 'User Role ID',
            'address' => 'Address',
            'bd' => 'Bd',
            'avatar' => 'Avatar',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'rate' => 'Rate',
            'city_id' => 'City ID',
            'last_activity_time' => 'Last Activity Time',
            'finished_task_count' => 'Finished Task Count',
            'opinions_count' => 'Opinions Count',
        ];
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery|FavouritesQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourites::class, ['favourite_person_id' => 'id']);
    }

    /**
     * Gets query for [[Favourites0]].
     *
     * @return \yii\db\ActiveQuery|FavouritesQuery
     */
    public function getFavourites0()
    {
        return $this->hasMany(Favourites::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery|NotificationsQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery|OpinionsQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::class, ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[PortfolioPhotos]].
     *
     * @return \yii\db\ActiveQuery|PortfolioPhotoQuery
     */
    public function getPortfolioPhotos()
    {
        return $this->hasMany(PortfolioPhoto::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::class, ['doer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::class, ['doer_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery|UserCategoryQuery
     */
    public function getCategories()
    {
        return $this->hasMany(UserCategory::class, ['user_id' => 'id']);
    }

    public function getUserCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UserRole]].
     *
     * @return \yii\db\ActiveQuery|UserRoleQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserRole::class, ['id' => 'user_role_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    final public static function findDoersByFilters(UserSearchForm $form): ?array
    {
        $query = self::find()
            ->where(['user_role_id' => '1'])
            ->with('userCategories')
            ->groupBy('users.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray();
        $query->withOpinionsFilter(0);

        return $query->all();
    }


    final public static function getDoersByDate()
    {
        return self::find()
            ->where(['user_role_id' => '1'])
            ->with('userCategories')
            ->groupBy('users.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray()->all();
    }
}
