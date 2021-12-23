<?php
declare(strict_types=1);

namespace frontend\models\cities;

use frontend\models\{tasks\Tasks, users\Users};
use Yii;
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

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['city', 'latitude', 'longitude', 'value'], 'required'],
            [['city', 'latitude', 'longitude', 'value'], 'string', 'max' => 255],
            [['city', 'latitude', 'longitude', 'value'], 'safe']
        ];
    }

    /**
     * Get all cities
     *
     * @returns array
     */
    public function getCities(): array
    {
        $this->cities = ArrayHelper::map(Cities::getAll(), 'id', 'city');

        return $this->cities;
    }

    public function setSessionCity($user)
    {
        if (property_exists($user, 'city_id')) {
            $session = Yii::$app->session;
            $session->set('city', $user->city_id);
        }
    }

    /**
     * Get all cities
     *
     * @returns array
     */
    final public static function getAll(): array
    {
        return self::find()->asArray()->all();
    }
}
