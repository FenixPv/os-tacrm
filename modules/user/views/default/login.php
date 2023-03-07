<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\modules\user\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title                   = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-login mx-auto py-5">

    <?php $form = ActiveForm::begin([
        'id'          => 'login-form',
        'layout'      => 'horizontal',
        'fieldConfig' => [
            'template'     => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]);

    echo $form->field($model, 'login')->textInput();
    echo $form->field($model, 'password')->passwordInput();

    echo $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"text-center custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-7\">{error}</div>",
    ]);
    ?>

    <div class="form-group">
        <div class="offset-lg-3 col-lg-6">
            <?= Html::submitButton('Login', ['class' => 'btn btn-dark w-100', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
