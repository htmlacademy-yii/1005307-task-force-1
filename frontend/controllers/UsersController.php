<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\users\Users;
use app\models\users\UserSearchForm;

class UsersController extends Controller
{
    public function actionIndex(): string
    {
        $searchForm = new UserSearchForm();
        $users = Users::getDoersByDate();
        return $this->render('index', compact('users', 'searchForm' ));
    }
}
