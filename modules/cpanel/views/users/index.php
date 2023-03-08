<?php

use app\modules\user\models\Users;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cpanel\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t('app', 'Управление пользователями');
$this->params['breadcrumbs'][] = ['label' => 'Контрольная панель', 'url' => ['/cpanel']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <div class="text-end my-3">
        <?php
        echo Html::a(Yii::t('app', 'Добавить пользователя'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>

    <?php
    /** @noinspection PhpUnhandledExceptionInspection */
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'layout' => '{items}{pager}{summary}',
        'tableOptions' => [
            'class' => 'table table-striped'
        ],
        'columns'      => [
            [
                'attribute'      => 'id',
                'headerOptions'  => [
                    'style' => 'width:4rem',
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center',
                ],
            ],
            'login',
            'email:email',
            [
                'filter'    => Users::getStatusesArray(),
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function ($model, $key, $index, $column) {
                    /** @var Users $model */
                    /** @var DataColumn $column */
                    $value = $model->{$column->attribute};
                    $class = match ($value) {
                        Users::STATUS_ACTIVE => 'success',
                        Users::STATUS_BLOCKED => 'warning',
                        default => 'default',
                    };
                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge bg-' . $class]);
                    return $value === null ? $column->grid->emptyCell : $html;
                }
            ],
            [
                'attribute' => 'userRole',
                'format'    => 'raw',
                'value'     => function ($role) {
                    return $role->userRole->item_name;
                }

            ],
            [
                'class'      => ActionColumn::class,
                'header'     => 'Действия',
                'urlCreator' => function ($action, Users $model) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template'   => '{view} {update}{link}',
            ],

        ],
    ]); ?>


</div>
