<?php
declare(strict_types = 1);

namespace frontend\models\cities;

use frontend\models\{
    tasks\Tasks,
    users\Users
};

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $city
 * @property string $latitude
 * @property string $longitude
 *
 * @property Tasks[] $tasks
 * @property Users[] $users
 */

class Cities extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'cities';
    }

    public function rules(): array
    {
        return [
            [['city', 'latitude', 'longitude'], 'required'],
            [['city', 'latitude', 'longitude'], 'string', 'max' => 255],
        ];
    }

    public function getCities(): array
    {
        if (!isset($this->cities)) {
            $this->cities = ArrayHelper::map(Cities::getAll(), 'id', 'city');
        }

        return $this->cities;
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Tasks::class, ['city_id' => 'id']);
    }

    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['city_id' => 'id']);
    }

    public static function find(): CitiesQuery
    {
        return new CitiesQuery(get_called_class());
    }

    final public static function getAll(): array
    {
        return self::find()->asArray()->all();
    }
}
