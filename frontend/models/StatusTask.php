<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status_task".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 *
 * @property Tasks[] $tasks
 */
class StatusTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['name', 'type'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['status_task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StatusTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatusTaskQuery(get_called_class());
    }
}
