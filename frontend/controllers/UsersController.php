<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\users\Users;
use frontend\models\users\UserSearchForm;
use yii\data\ActiveDataProvider;
use yii\web\Response;

use Yii;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

class UsersController extends SecuredController
{
    public function init()
    {
        parent::init();

        if (!Yii::$app->user->isGuest) {
            $user = Users::findOne(Yii::$app->user->id);
            $user->last_activity_time = date('Y-m-d H:i:s');
            $user->save(false, ["last_activity_time"]);
        }
    }

    public function actionJson() {
        $contacts = Users::find()->asArray()->all();

        $response = Yii::$app->response;
        $response->data = $contacts;
        $response->format = Response::FORMAT_JSON;

        return $response;
    }

    public function actionIndex(): string
    {
        $searchForm = new UserSearchForm();
        $dataProvider = $searchForm->search(Yii::$app->request->queryParams);

        $dataProvider = new ActiveDataProvider([
            'query' => Users::getDoersByFilters($searchForm),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchForm' => $searchForm]);
    }

    public function actionView($id = null): string
    {
        $user = Users::getOneUser($id);

        if (!$user) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $this->render('view', ['user' => $user]);
    }
}
