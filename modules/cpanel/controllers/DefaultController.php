<?php

namespace app\modules\cpanel\controllers;

use yii\web\Controller;

/**
 * Default controller for the `cpanel` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        var_dump(123);
        return $this->render('index');
    }
}
