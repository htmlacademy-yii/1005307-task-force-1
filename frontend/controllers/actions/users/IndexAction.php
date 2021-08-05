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
    public function run(): string
    {
        $searchForm = new UserSearchForm();
        $dataProvider = $searchForm->search(Yii::$app->request->queryParams);

        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
            'searchForm' => $searchForm
        ]);
    }
}

