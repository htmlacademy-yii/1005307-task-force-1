<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $about
 * @property int|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int|null $user_id
 * @property int|null $city_id
 * @property string|null $avatar
 * @property float|null $rating
 *
 * @property Cities $city
 * @property Users $user
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bd'], 'safe'],
            [['about'], 'string'],
            [['phone', 'user_id', 'city_id'], 'integer'],
            [['rating'], 'number'],
            [['address', 'skype', 'telegram', 'avatar'], 'string', 'max' => 128],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'bd' => 'Bd',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'user_id' => 'User ID',
            'city_id' => 'City ID',
            'avatar' => 'Avatar',
            'rating' => 'Rating',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
