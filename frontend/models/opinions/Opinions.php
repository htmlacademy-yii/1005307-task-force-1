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
 * @property string $title
 * @property string $description
 * @property float|null $rate
 * @property int $writer_id
 * @property int $about_id
 * @property int $task_id
 *
 * @property Users $about
 * @property Tasks $task
 * @property Users $writer
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
            [['title', 'description', 'writer_id', 'about_id', 'task_id'], 'required'],
            [['description'], 'string'],
            [['rate'], 'number'],
            [['writer_id', 'about_id', 'task_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['about_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['about_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['writer_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'title' => 'Title',
            'description' => 'Description',
            'rate' => 'Rate',
            'writer_id' => 'Writer ID',
            'about_id' => 'About ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getWriter(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'writer_id']);
    }

    public function getAbout(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'about_id']);
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
