<?php

namespace frontend\modules\api\controllers;

use frontend\models\messages\Messages;
use frontend\models\notifications\Notifications;
use frontend\models\users\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

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
            if ($userId === $message->recipient_id) {
                $message->unread = 0;
                $message->save();
            }
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
        $newMessage->unread = 1;

        $user_id === $newMessage->task->doer_id ?
            $newMessage->recipient_id = $newMessage->task->client_id
            : $newMessage->recipient_id = $newMessage->task->doer_id;

        if (Users::find()->where(['id' => $newMessage->recipient_id])->exists()) {
            if ($newMessage->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $notification = new Notifications();
                $notification->addNotification(
                    $newMessage->task_id,
                    2,
                    $newMessage->recipient_id,
                    'is_subscribed_messages'
                );
            } elseif (!$newMessage->hasErrors()) {
                throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
        }

        return json_encode($newMessage->toArray());
    }
}
