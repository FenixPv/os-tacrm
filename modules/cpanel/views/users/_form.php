<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\user\models\Users $user
 * @var app\modules\user\models\UserRole $roles
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="users-form">

    <?php

    $form = ActiveForm::begin([
        'fieldConfig' => [
            'template'     => "{label}\n{input}\n{error}",
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]);
    $paramsDropDownList = [
        'prompt' => 'Выберите статус...',
        'options' => ['Выберите статус...' => ['Selected' => true]],
    ];

    echo $form->field($user, 'login')->textInput(['maxlength' => true]);
    echo $form->field($user, 'password_hash')->textInput(['maxlength' => true])->passwordInput();
    echo $form->field($user, 'email')->textInput(['maxlength' => true]);
    echo $form->field($user, 'status')->dropDownList(
        $user->getStatusesArray(),
        $paramsDropDownList
    );
    echo $form->field($roles, 'item_name')->dropDownList(
        $roles->getRolesArray(),
        $paramsDropDownList
    );

    ?>


    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
