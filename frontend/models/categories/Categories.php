<?php
declare(strict_types=1);

namespace frontend\models\categories;

use frontend\models\{tasks\Tasks, users\UserCategory};
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string|null $profession
 *
 * @property Tasks[] $tasks
 * @property UserCategory[] $userCategories
 */
class Categories extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'categories';
    }

    public function rules(): array
    {
        return [
            [['name', 'icon'], 'required'],
            [['name', 'icon', 'profession'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['icon'], 'unique'],
            [['profession'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'profession' => 'Profession',
        ];
    }

    public static function getCategoriesFilters(): array
    {
        return ArrayHelper::map(Categories::getAll(), 'id', 'name');
    }

    final public static function getAll(): array
    {
        return self::find()->asArray()->all();
    }
}
