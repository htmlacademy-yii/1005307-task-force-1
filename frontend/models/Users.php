<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $dt_add
 * @property int $user_role_id
 *
 * @property Favourites[] $favourites
 * @property Favourites[] $favourites0
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property PortfolioPhoto[] $portfolioPhotos
 * @property Profiles[] $profiles
 * @property Replies[] $replies
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategory[] $userCategories
 * @property UserRole $userRole
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
            [['email', 'name', 'password', 'user_role_id'], 'required'],
            [['dt_add'], 'safe'],
            [['user_role_id'], 'integer'],
            [['email', 'name', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['name'], 'unique'],
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
        ];
    }

    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourites::className(), ['favourite_person_id' => 'id']);
    }

    /**
     * Gets query for [[Favourites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites0()
    {
        return $this->hasMany(Favourites::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[PortfolioPhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioPhotos()
    {
        return $this->hasMany(PortfolioPhoto::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['doer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['doer_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserRole::className(), ['id' => 'user_role_id']);
    }
}
