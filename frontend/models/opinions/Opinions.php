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
    private $completion;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'opinions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['description', 'dt_add'], 'string'],
            [['client_id', 'completion', 'doer_id', 'rate', 'task_id'], 'integer'],
            [['client_id', 'completion', 'doer_id', 'task_id', 'dt_add'], 'required'],
            [['client_id', 'completion', 'description', 'doer_id', 'dt_add', 'rate', 'task_id'], 'safe'],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }
}
