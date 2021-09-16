<?php
declare(strict_types = 1);

namespace frontend\models\account;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class UserIdentity extends ActiveRecord implements IdentityInterface
{
    private $_id;
    private $email;

    public static function tableName(): string
    {
        return 'users';
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password): bool
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getEmail()
    {
        return $this->email;
    }

    private $_model = null;
    //private $email;
    private function getModel()
    {
        if (!$this->isGuest && $this->_model === NULL) {
            $this->_model = Client::model()->findByPk($this->id, array('select'=>array('email')));
        }
        return $this->_model;
    }
}
