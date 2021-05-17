<?php

namespace app\models\replies;

use Yii;
use app\models\{
    tasks\Tasks,
    users\Users
};

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property string $dt_add
 * @property float|null $rate
 * @property string $title
 * @property string $description
 * @property int $doer_id
 * @property int $task_id
 *
 * @property Users $doer
 * @property Tasks $task
 */
class Replies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['rate'], 'number'],
            [['title', 'description', 'doer_id', 'task_id'], 'required'],
            [['description'], 'string'],
            [['doer_id', 'task_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['doer_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'rate' => 'Rate',
            'title' => 'Title',
            'description' => 'Description',
            'doer_id' => 'Doer ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[Doer]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getDoer()
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    /**
     * {@inheritdoc}
     * @return RepliesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RepliesQuery(get_called_class());
    }
}
