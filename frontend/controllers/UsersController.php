<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\users\UserSearchForm;
use app\models\users\UserService;
use app\models\tasks\Tasks;
use app\models\opinions\Opinions;

class UsersController extends Controller
{
    public function actionIndex(): string
    {
        $request = Yii::$app->request;
        $searchForm = new UserSearchForm();
        $userService = new UserService($request);
        $tasks = new Tasks();
        $opinions = new Opinions();
        $users = $userService->getUsers($searchForm);
        return $this->render('index', compact('users', 'searchForm', 'tasks', 'opinions' ));
    }
}
