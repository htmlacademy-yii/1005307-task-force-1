<?php
declare(strict_types=1);

namespace frontend\models\users;

/**
 * This is the model class for table "users_optional_settings".
 *
 * @property int $user_id
 * @property int $is_hidden_contacts
 * @property int $is_hidden_account
 * @property int $is_subscribed_messages
 * @property int $is_subscribed_actions
 * @property int $is_subscribed_reviews
 *
 * @property Users $users
 */
class UserOptionSettings extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_option_set';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'is_hidden_contacts', 'is_hidden_account', 'is_subscribed_messages', 'is_subscribed_actions', 'is_subscribed_reviews'], 'required'],
            [['user_id', 'is_hidden_contacts', 'is_hidden_account', 'is_subscribed_messages', 'is_subscribed_actions', 'is_subscribed_reviews'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'user_id' => 'User ID',
            'is_hidden_contacts' => 'Is Hidden Contacts',
            'is_hidden_account' => 'Is Hidden Account',
            'is_subscribed_messages' => 'Is Subscribed Messages',
            'is_subscribed_actions' => 'Is Subscribed Actions',
            'is_subscribed_reviews' => 'Is Subscribed Reviews',
        ];
    }
}
