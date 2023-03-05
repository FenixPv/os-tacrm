<?php

use app\modules\user\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cpanel\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t('app', 'Управление пользователями');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <p>
        <?= Html::a(Yii::t('app', 'Добавить пользователя'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped'
        ],
        'columns'      => [
            [
                'attribute'     => 'id',
                'headerOptions' => [
                    'style' => 'width:50px',
                ],
            ],
            'login',
            'email:email',
            'created_at:date',
            [
                'filter'    => Users::getStatusesArray(),
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function ($model, $key, $index, $column) {
                    /** @var Users $model */
                    /** @var \yii\grid\DataColumn $column */
                    $value = $model->{$column->attribute};
                    switch ($value) {
                        case Users::STATUS_ACTIVE:
                            $class = 'success';
                            break;
                        case Users::STATUS_BLOCKED:
                            $class = 'warning';
                            break;
                        default:
                            $class = 'default';
                    };
                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge bg-' . $class]);
                    return $value === null ? $column->grid->emptyCell : $html;
                }
            ],
            [
                'class'      => ActionColumn::className(),
                'header'=>'Действия',
                'urlCreator' => function ($action, Users $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update}{link}',
            ],
        ],
    ]); ?>


</div>
