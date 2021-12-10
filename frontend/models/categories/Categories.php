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
 * @property string $icon
 * @property string $name
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
            [['icon', 'name', 'profession'], 'string', 'max' => 255],
            [['icon', 'name'], 'required'],
            [['icon', 'name', 'profession'], 'unique'],
            [['icon', 'name', 'profession'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'icon' => 'Icon',
            'name' => 'Name',
            'profession' => 'Profession',
        ];
    }

    public static function getCategories(): array
    {
        return ArrayHelper::map(Categories::getAll(), 'id', 'name');
    }

    final public static function getAll(): array
    {
        return self::find()->asArray()->all();
    }
}
