<?php

/**
 * @var yii\web\View $this
 * @var app\modules\user\models\Users $user
 * @var app\modules\user\models\UserRole $roles
 */

$this->title = 'Новый пользователь';
$this->params['breadcrumbs'][] = ['label' => 'Контрольная панель', 'url' => ['/cpanel']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="cpanel-users-create offset-lg-3 col-lg-6">

    <?= $this->render('_form', [
        'user' => $user,
        'roles' => $roles,
    ]) ?>

</div>
