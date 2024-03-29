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
 * @property int|null $vk_id
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
    private $city_id;
    private $avatar;
    private $user_role;
    private $password;
    private $created_tasks;
    private $done_tasks;
    private $failed_tasks;
    private $rating;
    private $opinions_count;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['about', 'avatar', 'birthday', 'dt_add', 'email', 'last_activity_time', 'name', 'password', 'phone', 'skype', 'telegram', 'user_role'], 'string', 'max' => 255],
            [['city_id', 'created_tasks', 'done_tasks', 'failed_tasks', 'opinions_count', 'vk_id'], 'integer'],
            [['rating'], 'number'],
            [['city_id', 'created_tasks', 'done_tasks', 'email', 'failed_tasks', 'name', 'opinions_count', 'password', 'user_role'], 'required'],
            [['email'], 'unique'],
            [['created_tasks', 'done_tasks', 'dt_add', 'failed_tasks', 'last_activity_time', 'opinions_count', 'rating', 'vk_id'], 'safe'],
            [['about', 'avatar', 'birthday', 'city_id', 'email', 'name', 'password', 'phone', 'skype', 'telegram'], 'safe',
                'on' => self::SCENARIO_UPDATE],
            [['city_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Cities::class,
                'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'about' => 'About',
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
            'opinions_count' => 'Opinions Count',
            'password' => 'Password',
            'phone' => 'Phone',
            'rating' => 'Rating',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'user_role' => 'User Role',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }


    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites(): ActiveQuery
    {
        return $this->hasMany(Favourites::class, ['favourite_person_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions(): ActiveQuery
    {
        return $this->hasMany(Opinions::class, ['doer_id' => 'id']);
    }

    /**
     * Gets query for [[OptionSet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptionSet(): ActiveQuery
    {
        return $this->hasOne(UserOptionSettings::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Portfolio photo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioPhotos(): ActiveQuery
    {
        return $this->hasMany(PortfolioPhoto::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     *
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find(): UsersQuery
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * Gets one user
     *
     * @param $id
     * @return Users
     */
    final public static function getOneUser($id): Users
    {
        return self::findOne($id);
    }

    /**
     * Gets model
     *
     * @return Users
     */
    public function findModel(): Users
    {
        return self::findOne(\Yii::$app->user->identity->getId());
    }

    /**
     * Checks if current user is client of executant task
     *
     * @param $user_id
     * @param $account_user_id
     * @return array
     */
    public function getClientOfActiveTask($user_id, $account_user_id): array
    {
        return Tasks::find()->where(['status_task' => 'На исполнении'])
            ->andWhere(['client_id' => $account_user_id])
            ->andWhere(['doer_id' => $user_id])->asArray()->all();
    }

    /**
     * Checks if current user is doer of executant task
     *
     * @param $user_id
     * @param $account_user_id
     * @return array
     */
    public function getDoerOfActiveTask($user_id, $account_user_id): array
    {
        return Tasks::find()->where(['status_task' => 'На исполнении'])
            ->andWhere(['client_id' => $user_id])
            ->andWhere(['doer_id' => $account_user_id])->asArray()->all();
    }
}
