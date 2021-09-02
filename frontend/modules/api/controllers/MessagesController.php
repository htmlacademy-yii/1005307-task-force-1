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
    public $messages;

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider(): ActiveDataProvider
    {
        $taskId = Yii::$app->request->get('task_id');
        $userId = Yii::$app->user->getId();
        $this->messages = new ActiveDataProvider([
            'query' => Messages::find()
                ->where(['task_id' => $taskId])
                ->orderBy('published_at ASC')
        ]);
        foreach ($this->messages ?? [] as $message) {
            var_dump($message);
            $message->is_mine = $userId === $message->getUser()->user_id;
        }

        return $this->messages;
    }

    public function actionView(): ActiveDataProvider
    {
        $messages = $this->prepareDataProvider();

        return $messages;
    }

    public function actionAddMessage()
    {
        $user_id = Yii::$app->user->getId();
        $taskId = Yii::$app->request->get('task_id');
        $newMessage = new $this->modelClass();
        $newMessage->load(Yii::$app->getRequest()->getBodyParams(), '');
        $newMessage->user_id = $user_id;
        $newMessage->task_id = $taskId;

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
