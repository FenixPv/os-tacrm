<?php

namespace app\modules\cpanel\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `cpanel` module
 */
class DefaultController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
//                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
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
}
