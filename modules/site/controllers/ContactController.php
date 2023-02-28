<?php

namespace app\modules\site\controllers;


use app\modules\site\models\ContactForm;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/** @noinspection PhpUnused */

class ContactController extends Controller
{
    /**
     * @return array[]
     */
    public function actions(): array
    {
        return [
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(): Response|string
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}