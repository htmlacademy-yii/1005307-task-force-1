<?php
declare(strict_types = 1);

namespace frontend\models\cities;

use yii\base\Model;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $city
 */

class SetCityForm extends Model
{
    public $city;
    public static function tableName(): string
    {
        return 'city';
    }

    public function rules(): array
    {
        return [
            [['city'], 'required'],
            [['city'], 'string', 'max' => 255],
            [['city'], 'safe'],
        ];
    }
}
