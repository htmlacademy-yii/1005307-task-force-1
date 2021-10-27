<?php

namespace frontend\modules\api\controllers;

use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use frontend\models\messages\Messages;
use frontend\models\notifications\Notifications;
use frontend\models\users\Users;
use yii\web\ServerErrorHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use Yii;

/**
 * Default controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = Messages::class;

    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'xml' => Response::FORMAT_XML,
                ],
            ],
        ];
    }

    public function checkAccess($action, $model = null, $params = []): bool
    {
        return true;
    }

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'actionView'];

        unset($actions['create']);

        return $actions;
    }

    public function prepareDataProvider(): ActiveDataProvider
    {
        $taskId = Yii::$app->request->get('task_id');
        $messages = new ActiveDataProvider([
            'query' => Messages::find()
                ->where(['task_id' => $taskId])
                ->orderBy('published_at ASC'),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $messages;
    }

    public function actionView(): array
    {
        $userId = Yii::$app->user->getId();
        $messages = $this->prepareDataProvider()->getModels();

        foreach ($messages as $key => $message) {
            $message->is_mine = $userId === $message->writer_id ? 1 : 0;
            $messages[$key] = $message;
        }

        return $messages;
    }

    public function actionCreate()
    {
        $post = json_decode(Yii::$app->request->getRawBody());
        $user_id = Yii::$app->user->id;
        $newMessage = new $this->modelClass();
        $newMessage->message = $post->message;
        $newMessage->writer_id = $user_id;
        $newMessage->task_id = $post->task_id;

        $user_id === $newMessage->task->doer_id ?
            $newMessage->recipient_id = $newMessage->task->client_id
            : $newMessage->recipient_id = $newMessage->task->doer_id;

        if (Users::find()->where(['id' => $newMessage->recipient_id])->exists()) {
            if ($newMessage->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
            } elseif (!$newMessage->hasErrors()) {
                throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
        }
        $notification = new Notifications();
        $notification->notification_category_id = 2;
        $notification->task_id = $newMessage->task_id;
        $notification->visible = 1;
        $notification->user_id = $newMessage->recipient_id;
        $notification->save();

        return json_encode($newMessage->toArray());
    }
}
