<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\user\models\Users $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-form">

    <?php

    $form = ActiveForm::begin();

    ?>

<!--    --><?php //= $form->field($model, 'created_at')->textInput() ?>

<!--    --><?php //= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'email_confirm_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
