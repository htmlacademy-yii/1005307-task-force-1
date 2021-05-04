<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $dt_add
 * @property int|null $category_id
 * @property string $description
 * @property string|null $expire
 * @property string $name
 * @property string|null $address
 * @property int|null $budget
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $location_comment
 * @property int|null $city_id
 * @property int|null $doer_id
 * @property int $client_id
 * @property int $status_task_id
 *
 * @property FileTask[] $fileTasks
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property Replies[] $replies
 * @property Categories $category
 * @property Cities $city
 * @property Users $client
 * @property Users $doer
 * @property StatusTask $statusTask
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add', 'expire'], 'safe'],
            [['category_id', 'budget', 'city_id', 'doer_id', 'client_id', 'status_task_id'], 'integer'],
            [['description', 'name', 'client_id', 'status_task_id'], 'required'],
            [['description'], 'string'],
            [['name', 'address', 'latitude', 'longitude', 'location_comment'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['doer_id' => 'id']],
            [['status_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusTask::className(), 'targetAttribute' => ['status_task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
            'status_task_id' => 'Status Task ID',
        ];
    }

    /**
     * Gets query for [[FileTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileTasks()
    {
        return $this->hasMany(FileTask::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Doer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoer()
    {
        return $this->hasOne(Users::className(), ['id' => 'doer_id']);
    }

    /**
     * Gets query for [[StatusTask]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatusTask()
    {
        return $this->hasOne(StatusTask::className(), ['id' => 'status_task_id']);
    }
}
