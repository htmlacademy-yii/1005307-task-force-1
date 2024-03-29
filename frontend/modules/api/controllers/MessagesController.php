<?php

namespace frontend\modules\api\controllers;

use frontend\models\messages\Messages;
use frontend\models\notifications\Notifications;
use frontend\models\users\UserOptionSettings;
use frontend\models\users\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * Default controller for the `api` module
 */
class MessagesController extends ActiveController
{
    public $modelClass = Messages::class;

    /**
     * {@inheritdoc}
     *
     * @return array[]
     */
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

    /**
     * checks access for action
     * @param string $action
     * @param null $model
     * @param array $params
     * @return bool
     */
    public function checkAccess($action, $model = null, $params = []): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'actionView'];

        unset($actions['create']);

        return $actions;
    }

    /**
     * Shows messages
     *
     * {@inheritdoc}
     */
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

    /**
     * Shows messages && makes them read
     * @return array
     */
    public function actionView(): array
    {
        $userId = Yii::$app->user->getId();
        $messages = $this->prepareDataProvider()->getModels();

        foreach ($messages as $key => $message) {
            if (property_exists($message, 'is_mine') && property_exists($message, 'writer_id')) {
                $message->is_mine = $userId === $message->writer_id ? 1 : 0;
                $messages[$key] = $message;
                if ($userId === $message->recipient_id) {
                    $message->unread = 0;
                    $message->save();
                }
            }
        }

        return $messages;
    }

    /**
     * Creates message
     *
     * @return false|string
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        $post = json_decode(Yii::$app->request->getRawBody());
        $user_id = Yii::$app->user->id;
        $newMessage = new $this->modelClass([
            'message' => $post->message,
            'writer_id' => $user_id,
            'task_id' => $post->task_id,
            'unread' => 1
        ]);

        $user_id === $newMessage->task->doer_id ?
            $newMessage->recipient_id = $newMessage->task->client_id
            : $newMessage->recipient_id = $newMessage->task->doer_id;

        if (Users::find()->where(['id' => $newMessage->recipient_id])->exists()) {
            if ($newMessage->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
                $user_set = UserOptionSettings::findOne($newMessage->recipient_id);

                if (property_exists($user_set, 'is_subscribed_messages') && $user_set['is_subscribed_messages'] == 1) {
                    $notification = new Notifications([
                        'notification_category_id' => 2,
                        'task_id' => $newMessage->task_id,
                        'visible' => 1,
                        'user_id' => $newMessage->recipient_id
                    ]);
                    $notification->save(false);
                    $notification->addNotification();
                }
            } elseif (!$newMessage->hasErrors()) {
                throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
            }
        } else {
            throw new ServerErrorHttpException('Не удалось создать сообщение чата по неизвестным причинам.');
        }

        return json_encode($newMessage->toArray());
    }
}
