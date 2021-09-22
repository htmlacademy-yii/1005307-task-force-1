<?php
declare(strict_types = 1);

namespace frontend\models\opinions;

use frontend\models\{
    tasks\Tasks,
    users\Users
};

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "opinions".
 *
 * @property int $id
 * @property string $dt_add
 * @property string $completion
 * @property string $description
 * @property float|null $rate
 * @property int $doer_id
 * @property int $client_id
 * @property int $task_id
 *
 * @property Users $doer
 * @property Tasks $task
 * @property Users $client
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
            [['completion', 'description', 'rate', 'doer_id', 'client_id', 'task_id'], 'required'],
            [['description'], 'string'],
            [['completion'], 'string'],
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
            'dt_add' => 'Dt Add',
            'completion' => 'Status Opinion',
            'description' => 'Description',
            'rate' => 'Rate',
            'doer_id' => 'Doer ID',
            'client_id' => 'Client ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'client_id']);
    }

    public function getDoer(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public static function find(): OpinionsQuery
    {
        return new OpinionsQuery(get_called_class());
    }
}
