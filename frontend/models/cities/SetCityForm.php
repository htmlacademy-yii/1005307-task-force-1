<?php
declare(strict_types=1);

namespace frontend\models\cities;

use yii\base\Model;

class SetCityForm extends Model
{
    public $city;

    public function rules(): array
    {
        return [
            [['city'], 'required'],
            [['city'], 'string', 'max' => 255],
            [['city'], 'safe'],
        ];
    }
}
