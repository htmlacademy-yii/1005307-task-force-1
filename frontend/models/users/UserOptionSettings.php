<?php
declare(strict_types=1);

namespace frontend\models\users;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_optional_settings".
 *
 * @property int $is_hidden_account
 * @property int $is_hidden_contacts
 * @property int $is_subscribed_actions
 * @property int $is_subscribed_messages
 * @property int $is_subscribed_reviews
 * @property int $user_id
 *
 * @property Users $users
 */
class UserOptionSettings extends ActiveRecord
{
    private $is_hidden_account;
    private $is_hidden_contacts;
    private $is_subscribed_actions;
    private $is_subscribed_messages;
    private $is_subscribed_reviews;
    private $user_id;

    public static function tableName(): string
    {
        return 'user_option_set';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'is_hidden_account', 'is_hidden_contacts', 'is_subscribed_actions', 'is_subscribed_messages', 'is_subscribed_reviews'], 'integer'],
            [['user_id', 'is_hidden_account', 'is_hidden_contacts', 'is_subscribed_actions', 'is_subscribed_messages', 'is_subscribed_reviews'], 'required'],
            [['user_id', 'is_hidden_account', 'is_hidden_contacts', 'is_subscribed_actions', 'is_subscribed_messages', 'is_subscribed_reviews'], 'safe'],
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
            'is_hidden_account' => 'Is Hidden Account',
            'is_hidden_contacts' => 'Is Hidden Contacts',
            'is_subscribed_actions' => 'Is Subscribed Actions',
            'is_subscribed_messages' => 'Is Subscribed Messages',
            'is_subscribed_reviews' => 'Is Subscribed Reviews',
            'user_id' => 'User ID',
        ];
    }
}
