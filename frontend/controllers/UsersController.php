<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use yii\db\Query;
use app\models\Users as User;

/**
 * Users controller
 */
class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find();
        //    ->where(['role_id' => '3'])
        //    ->with('city')->asArray()->all();

        return $this->render('users', ['users' => $users]);
    }
}
