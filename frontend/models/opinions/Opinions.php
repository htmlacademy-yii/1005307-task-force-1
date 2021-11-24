<?php
declare(strict_types=1);

namespace frontend\models\opinions;

use frontend\models\{tasks\Tasks, users\Users};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "opinions".
 *
 * @property int $id
 * @property int $client_id
 * @property string $completion
 * @property string|null $description
 * @property int $doer_id
 * @property string $dt_add
 * @property float|null $rate
 * @property int $task_id
 *
 * @property Users $client
 * @property Users $doer
 * @property Tasks $task
 */
class Opinions extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'opinions';
    }

    public function rules(): array
    {
        return [
            [['dt_add'], 'safe'],
            [['completion', 'doer_id', 'client_id', 'task_id'], 'required'],
            [['description', 'completion'], 'string'],
            [['rate'], 'number'],
            [['doer_id', 'client_id', 'task_id'], 'integer'],
            [['doer_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['doer_id' => 'id']],
            [['task_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']],
            [['client_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'completion' => 'Status Opinion',
            'description' => 'Description',
            'doer_id' => 'Doer ID',
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'task_id' => 'Task ID',
        ];
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'client_id']);
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }
}
