<?php
declare(strict_types = 1);

namespace frontend\models\users;

use frontend\models\categories\Categories;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_category".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property Users $user
 */
class UserCategory extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_category';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'category_id'], 'required'],
            [['user_id', 'category_id'], 'integer'],
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

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find(): UserCategoryQuery
    {
        return new UserCategoryQuery(get_called_class());
    }
}
