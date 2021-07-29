<?php
declare(strict_types = 1);

namespace frontend\models\responses;

use frontend\models\{
    tasks\Tasks,
    users\Users
};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property string $dt_add
 * @property int $budget
 * @property string $description
 * @property int $doer_id
 * @property int $task_id
 *
 * @property Users $doer
 * @property Tasks $task
 */

class Responses extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'Responses';
    }

    public function rules(): array
    {
        return [
            [['dt_add'], 'safe'],
            [['budget'], 'number'],
            [['comment'], 'string'],
            [['budget', 'comment', 'doer_id', 'task_id'], 'required'],
            [['doer_id', 'task_id'], 'integer'],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['doer_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'budget' => 'Budget',
            'comment' => 'Comment',
            'doer_id' => 'Doer ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getDoer(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    public static function find(): ResponsesQuery
    {
        return new ResponsesQuery(get_called_class());
    }

    final public static function getUserResponse($id)
    {
        return self::find()
            ->andFilterWhere(['doer_id' => $id])
            ->all();
    }
}
