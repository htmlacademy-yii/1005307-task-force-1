<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $avatar
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property float|null $rate
 * @property int $user_id
 * @property int|null $city_id
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
            [['rate'], 'number'],
            [['user_id'], 'required'],
            [['user_id', 'city_id'], 'integer'],
            [['address', 'avatar', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
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
            'avatar' => 'Avatar',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'rate' => 'Rate',
            'user_id' => 'User ID',
            'city_id' => 'City ID',
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
