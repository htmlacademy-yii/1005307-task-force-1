<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "opinions".
 *
 * @property int $id
 * @property string $dt_add
 * @property string $title
 * @property string $description
 * @property float|null $rate
 * @property int $writer_id
 * @property int $task_id
 *
 * @property Tasks $task
 * @property Users $writer
 */
class Opinions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opinions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['title', 'description', 'writer_id', 'task_id'], 'required'],
            [['description'], 'string'],
            [['rate'], 'number'],
            [['writer_id', 'task_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['writer_id' => 'id']],
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
            'title' => 'Title',
            'description' => 'Description',
            'rate' => 'Rate',
            'writer_id' => 'Writer ID',
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
     * Gets query for [[Writer]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getWriter()
    {
        return $this->hasOne(Users::class, ['id' => 'writer_id']);
    }

    /**
     * {@inheritdoc}
     * @return OpinionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpinionsQuery(get_called_class());
    }
}
