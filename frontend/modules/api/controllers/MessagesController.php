<?php

namespace frontend\modules\api\controllers;

use frontend\controllers\actions\tasks\ViewAction;

//use frontend\modules\api\models\Messages;
use http\Message;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use frontend\models\messages\Messages;

//use frontend\models\messages\Messages;
use yii\data\ActiveDataFilter;

use frontend\modules\api\models\DataFilter;
use yii\web\ServerErrorHttpException;
use yii\helpers\Url;
use Yii;

/**
 * Default controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = Messages::class;

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        $actions['index']['dataFilter'] = [
            'class' => ActiveDataFilter::class,
            'searchModel' => $this->modelClass,
        ];

        return $actions;
    }

    public function prepareDataProvider(): ActiveDataProvider
    {
        $taskId = Yii::$app->request->get('task_id');
        return new ActiveDataProvider([
            'query' => Messages::find()
                ->where(['task_id' => 53])
                ->orderBy('published_at ASC')
        ]);
    }

    public function actionAddMessage()
    {
        $user_id = Yii::$app->user->getId();
        $newMessage = new $this->modelClass();
        $newMessage->load(Yii::$app->getRequest()->getBodyParams(), '');
        $newMessage->writer_id = $user_id;

        if ($newMessage->save(false)) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = $newMessage->getPrimaryKey();
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        } elseif (!$newMessage->hasErrors()) {
            throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
        }

        return $newMessage;
    }
}
