<?php
declare(strict_types = 1);

namespace frontend\models\replies;

use frontend\models\{
    tasks\Tasks,
    users\Users
};

use Yii;

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property string $dt_add
 * @property float|null $rate
 * @property int budget
 * @property string $description
 * @property int $doer_id
 * @property int $task_id
 *
 * @property Users $doer
 * @property Tasks $task
 */

class Replies extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'replies';
    }

    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['rate'], ['budget'], 'number'],
            [['description', 'doer_id', 'task_id'], 'required'],
            [['description'], 'string'],
            [['doer_id', 'task_id'], 'integer'],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['doer_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

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

    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getDoer()
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    public static function find()
    {
        return new RepliesQuery(get_called_class());
    }
}
