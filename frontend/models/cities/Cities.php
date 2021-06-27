<?php

namespace frontend\models\cities;

use Yii;
use frontend\models\{
    tasks\Tasks,
    users\Users
};

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

class Cities extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cities';
    }

    public function rules()
    {
        return [
            [['city', 'latitude', 'longitude'], 'required'],
            [['city', 'latitude', 'longitude'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['city_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(Users::class, ['city_id' => 'id']);
    }

    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }

    final public static function getAll()
    {
        return self::find()->asArray()->all();
    }
}
