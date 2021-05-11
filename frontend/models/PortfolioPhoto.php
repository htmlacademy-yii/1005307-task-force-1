<?php

namespace app\models;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portfolio_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
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
            'photo' => 'Photo',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return PortfolioPhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PortfolioPhotoQuery(get_called_class());
    }
}
