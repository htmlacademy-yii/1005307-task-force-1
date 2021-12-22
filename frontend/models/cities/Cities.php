<?php
declare(strict_types=1);

namespace frontend\models\cities;

use frontend\models\{tasks\Tasks, users\Users};
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $city
 * @property string $latitude
 * @property string $longitude
 * @property string $value
 *
 * @property Tasks[] $tasks
 * @property Users[] $users
 */
class Cities extends ActiveRecord
{
    private $cities;

    public static function tableName(): string
    {
        return 'cities';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'value' => 'Value',
        ];
    }

    public function rules(): array
    {
        return [
            [['city', 'latitude', 'longitude', 'value'], 'required'],
            [['city', 'latitude', 'longitude', 'value'], 'string', 'max' => 255],
            [['city', 'latitude', 'longitude', 'value'], 'safe']
        ];
    }

    public function getCities(): array
    {
        $this->cities = ArrayHelper::map(Cities::getAll(), 'id', 'city');

        return $this->cities;
    }

    final public static function getAll(): array
    {
        return self::find()->asArray()->all();
    }
}
