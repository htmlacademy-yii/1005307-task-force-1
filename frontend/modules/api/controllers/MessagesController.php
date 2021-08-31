<?php

namespace frontend\modules\api\controllers;

use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use frontend\models\messages\Messages;
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

        return $actions;
    }

    public function prepareDataProvider(): ActiveDataProvider
    {
        $taskId = Yii::$app->request->get('task_id');
        return new ActiveDataProvider([
            'query' => Messages::find()
                ->where(['task_id' => $taskId])
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
