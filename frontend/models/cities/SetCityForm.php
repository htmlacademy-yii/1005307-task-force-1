<?php
declare(strict_types=1);

namespace frontend\models\cities;

use yii\base\Model;

/**
 * Class SetCityForm
 * @package frontend\models\cities
 */
class SetCityForm extends Model
{
    public $city;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['city'], 'required'],
            [['city'], 'string', 'max' => 255],
            [['city'], 'safe'],
        ];
    }
}
