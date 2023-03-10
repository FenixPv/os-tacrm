<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\user\models\Users $model */

$this->title = Yii::t('app', 'Новый пользователь');
$this->params['breadcrumbs'][] = ['label' => 'Cpanel', 'url' => ['/cpanel']];
$this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
