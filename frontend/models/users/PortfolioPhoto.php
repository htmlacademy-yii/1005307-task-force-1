<?php

namespace app\models\users;

use Yii;

/**
 * This is the model class for table "portfolio_photo".
 *
 * @property int $id
 * @property string $photo
 * @property int $user_id
 *
 * @property Users $user
 */
class PortfolioPhoto extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'portfolio_photo';
    }

    public function rules()
    {
        return [
            [['photo', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'user_id' => 'User ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find()
    {
        return new PortfolioPhotoQuery(get_called_class());
    }
}
