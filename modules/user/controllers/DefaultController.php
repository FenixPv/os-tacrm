<?php

namespace app\modules\user\controllers;

use app\modules\user\models\LoginForm;
use app\modules\user\models\PasswordResetForm;
use app\modules\user\models\PasswordResetRequestForm;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /** @noinspection PhpUnused */
    public function actionLogin(): yii\web\Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /** @noinspection PhpUnused */
    public function actionLogout(): yii\web\Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /** @noinspection PhpUnused */
    public function actionPasswordResetRequest(): Response|string
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
            }
        }

        return $this->render('passwordResetRequest', [
            'model' => $model,
        ]);
    }

    /** @noinspection PhpUnused */

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionPasswordReset($token): Response|string
    {
        try {
            $model = new PasswordResetForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');

            return $this->goHome();
        }

        return $this->render('passwordReset', [
            'model' => $model,
        ]);
    }
}
