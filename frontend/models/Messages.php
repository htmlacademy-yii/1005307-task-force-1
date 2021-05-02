<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int|null $doer_id
 * @property int|null $client_id
 * @property string|null $text
 * @property int|null $task_id
 * @property string|null $dt_add
 *
 * @property Users $doer
 * @property Users $client
 * @property Tasks $task
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doer_id', 'client_id', 'task_id'], 'integer'],
            [['text'], 'string'],
            [['dt_add'], 'safe'],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['doer_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'doer_id' => 'Doer ID',
            'client_id' => 'Client ID',
            'text' => 'Text',
            'task_id' => 'Task ID',
            'dt_add' => 'Dt Add',
        ];
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
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
