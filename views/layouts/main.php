<?php

/**
 * @var yii\web\View $this
 * @var string $content
 */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header" class="sticky-top">
    <?php
    NavBar::begin([
        'brandLabel'            => Yii::$app->name,
        'brandUrl'              => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options'               => ['class' => 'navbar-expand-md navbar-dark bg-dark'],
    ]);

    if (Yii::$app->user->isGuest) {
        /** @noinspection PhpUnhandledExceptionInspection */
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'items'   => [
                ['label' => 'Войти', 'url' => ['/user/default/login'], 'class' => 'dropdown-menu-dark']
            ],
        ]);
    } else {
        /** @noinspection PhpUnhandledExceptionInspection */
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav mx-auto'],
            'items'   => [
                [
                    'label' => 'Контрольная панель',
                    'items' => [
                        ['label' => 'Пользователи', 'url' => '/cpanel/users/index'],
                        ['label' => 'Все инструменты', 'url' => '/cpanel'],
                    ],
                    'visible' => Yii::$app->user->can('viewCpanel'),
                ],
            ],

        ]);
        /** @noinspection PhpUnhandledExceptionInspection */
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'items'   => [
                [
                    'label' => Yii::$app->user->identity->login,
                    'items' => [
                        ['label' => 'Выйти', 'url' => '/user/default/logout'],
                    ],
                ],
            ],
        ]);
    }
    NavBar::end();
    ?>
</header>

<main id="main" class="my-3 flex-shrink-0" role="main">
    <div class="container-fluid">
        <?php
        if (!empty($this->params['breadcrumbs'])) {
            /** @noinspection PhpUnhandledExceptionInspection */
            echo Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]);
        }
        /** @noinspection PhpUnhandledExceptionInspection */
        echo Alert::widget();
        echo $content;
        ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
