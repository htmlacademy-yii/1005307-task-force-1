<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\tasks\Tasks;
use frontend\models\users\Users;
use frontend\models\users\UserSearchForm;
use yii\data\Pagination;

use Yii;
use yii\base\BaseObject;
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
        $query = Users::getDoersByFilters($searchForm);
        $page = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $users = $query->offset($page->offset)
            ->limit($page->limit)
            ->all();

        return $this->render('index', compact('users', 'searchForm', 'page'));
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
}
