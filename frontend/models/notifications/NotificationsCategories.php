<?php
declare(strict_types = 1);

namespace frontend\models\notifications;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $name
 * @property int $type
 */

class NotificationsCategories extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'notifications_categories';
    }

    public function rules(): array
    {
        return [
            [['name', 'type'], 'required'],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
        ];
    }
}
