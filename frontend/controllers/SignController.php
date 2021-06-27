<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\account\LoginForm;
use frontend\models\account\SignForm;
use frontend\models\account\SignHandler;
use frontend\models\users\Users;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class  SignController extends Controller
{
    private $signHandler;

    public function init()
    {
        parent::init();
        $this->signHandler = new SignHandler();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'actions' => ['sign', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        return true;
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

            if ($this->signHandler->login($loginForm)) {
                return $this->goHome();
            }
        }

        return $this->goHome();
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
