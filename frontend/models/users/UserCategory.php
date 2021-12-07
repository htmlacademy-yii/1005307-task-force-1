<?php
declare(strict_types=1);

namespace frontend\models\users;

use frontend\models\categories\Categories;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_category".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 *
 * @property Categories $category
 * @property Users $user
 */
class UserCategory extends ActiveRecord
{
    private $category_id;
    private $user_id;
    public static function tableName(): string
    {
        return 'user_category';
    }

    public function rules(): array
    {
        return [
            [['category_id', 'user_id'], 'integer'],
            [['category_id', 'user_id'], 'required'],
            [['category_id', 'user_id'], 'safe'],
            [['category_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Categories::class,
                'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
        ];
    }
}
