<?php

declare(strict_types=1);

namespace frontend\controllers\actions\users;

use frontend\models\users\Users;
use frontend\models\users\UserSearchForm;
use yii\base\Action;

use Yii;
use yii\data\ActiveDataProvider;

class IndexAction extends Action
{
    public function run()
    {
        $searchForm = new UserSearchForm();
        $searchForm->search(Yii::$app->request->queryParams);

        $dataProvider = new ActiveDataProvider([
            'query' => Users::getDoersByFilters($searchForm),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->controller->render('index', [
                'dataProvider' => $dataProvider,
                'searchForm' => $searchForm
        ]);
    }
}
