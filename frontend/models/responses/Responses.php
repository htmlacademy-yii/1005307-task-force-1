<?php
declare(strict_types=1);

namespace frontend\models\responses;

use frontend\models\{tasks\Tasks, users\Users};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property int $budget
 * @property string $comment
 * @property int $doer_id
 * @property string $dt_add
 * @property int $is_refused
 * @property int $task_id
 *
 * @property Users $doer
 * @property Tasks $task
 */
class Responses extends ActiveRecord
{
    private $is_refused;

    public static function tableName(): string
    {
        return 'Responses';
    }

    public function rules(): array
    {
        return [
            [['doer_id', 'task_id', 'is_refused', 'budget'], 'integer'],
            [['comment', 'dt_add'], 'string'],
            [['budget', 'comment', 'doer_id', 'dt_add', 'is_refused', 'task_id'], 'required'],
            [['budget', 'comment', 'doer_id', 'dt_add', 'is_refused', 'task_id'], 'safe'],
            [['doer_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['doer_id' => 'id']],
            [['task_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'budget' => 'Budget',
            'comment' => 'Comment',
            'doer_id' => 'Doer ID',
            'dt_add' => 'Dt Add',
            'task_id' => 'Task ID',
        ];
    }

    public static function find(): ResponsesQuery
    {
        return new ResponsesQuery(get_called_class());
    }

    public function getDoer(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    public function getUserResponse($id, $task_id): array
    {
        return self::find()->where(['doer_id' => $id])->andWhere(['task_id' => $task_id])->all();
    }
}
