<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\users\Users;
use frontend\models\users\UserSearchForm;

use Yii;
use yii\web\NotFoundHttpException;

class UsersController extends SecuredController
{
    public function init()
    {
        parent::init();
        //  $this->userAccount = \Yii::$app->user->getIdentity();
    }

    public function actionIndex(): string
    {
        $searchForm = new UserSearchForm();
        $searchForm->load($this->request->post());
        $users = Users::getDoersByFilters($searchForm);

        return $this->render('index', ['users' => $users, 'searchForm' => $searchForm]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id = null): string
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('view', ['user' => $user]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
