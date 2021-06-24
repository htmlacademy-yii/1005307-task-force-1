<?php


declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\users\UserSearchForm;
use app\models\users\Users;
use yii\web\NotFoundHttpException;

class SignController extends Controller
{
    public function actionIndex(): string
    {

        $searchForm = new UserSearchForm();
        $searchForm->load($this->request->post());
        $users = Users::getDoersByFilters($searchForm);

        return $this->render('index', ['users' => $users, 'searchForm' => $searchForm]);
    }
}
