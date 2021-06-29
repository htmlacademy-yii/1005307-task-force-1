<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\account\LoginForm;
use frontend\models\account\SignForm;
use frontend\models\users\Users;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class  SignController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if ($action->actionMethod === 'actionLogout') {
                        return $this->redirect(['landing/index']);
                    } else {

                        return $this->goHome();
                    }
                }
            ],
        ];
    }

    public function actionIndex(): string
    {
        $signForm = new SignForm();

        if (Yii::$app->request->getIsPost()) {
            $signForm->load(Yii::$app->request->post());

            if (!$signForm->validate()) {
                $errors = $signForm->getErrors();
            }

            $user = new Users(['attributes' => $signForm->attributes]);
            $user->password = Yii::$app->security->generatePasswordHash($signForm->password);

            if ($signForm->validate()) {
                $user->save(false);
                $this->goHome();
            }
        }

        return $this->render('index', ['signForm' => $signForm]);
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if ($loginForm->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);

                return $this->goHome();
            }
        }

        return $this->redirect(['landing/index']);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

