<?php


declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\models\Users as Users;
/**
 * Users controller
 */
class UsersController extends Controller
{
    public function actionIndex() : string
    {
        $users = Users::find()
            ->where(['user_role_id' => '1'])->asArray()->all();
        {
            return $this->render('index', ['users' => $users]);
        }
    }
}
