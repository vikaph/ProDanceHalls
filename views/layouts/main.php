<?php

/** @var yii\web\View $this */
/** @var string $content */

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



<header id="header">
  
<a href="<?= \yii\helpers\Url::to(['/site/index']) ?>" class="header-click-area"></a>
    <!-- NAVBAR -->
    <?php
    NavBar::begin([
        'brandLabel' => false,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md custom-navbar'
        ]
    ]);

    $items = [];

    if (Yii::$app->user->isGuest){
        $items[] = ['label' => 'Направления', 'url' => ['/dance-direction/index']];
        $items[] = ['label' => 'Залы', 'url' => ['/hall/index']];
        $items[] = ['label' => 'Тренеры', 'url' => ['/coach/index']];
        $items[] = ['label' => 'Расписание', 'url' => ['/schedule/index']];
        $items[] = ['label' => 'Цены', 'url' => ['/site/price']];
        $items[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
        if (Yii::$app->user->identity->is_admin==1) {
            $items[] = ['label' => 'Панель администратора', 'url' => ['/admin/index']];
        } else {
            $items[] = ['label' => 'Направления', 'url' => ['/dance-direction/index']];
            $items[] = ['label' => 'Залы', 'url' => ['/hall/index']];
            $items[] = ['label' => 'Тренеры', 'url' => ['/coach/index']];
            $items[] = ['label' => 'Расписание', 'url' => ['/schedule/index']];
            $items[] = ['label' => 'Цены', 'url' => ['/site/price']];
            $items[] = ['label' => 'Личный кабинет', 'url' => ['/site/cabinet']];
        }

        $items[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->login . ')',
                ['class' => 'nav-link btn btn-link logout-btn']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav mx-auto gap-2 text-center'],
        'items' => $items,
        'encodeLabels' => false
    ]);

    NavBar::end();
    ?>
</header>


<?php
$isHome = Yii::$app->controller->id === 'site'
    && Yii::$app->controller->action->id === 'index';
?>

<main id="main" class="flex-shrink-0" role="main">

<?php if (!$isHome): ?>
    <div class="container">
<?php endif; ?>

    <?= $content ?>

<?php if (!$isHome): ?>
    </div>
<?php endif; ?>

</main>

<footer id="footer" class="mt-auto">

    <div class="container footer-content">


        <p>
            © «ProDanceHalls», 2026
        </p>

        <p>
            📞 8 (904) 470-88-00
        </p>

        <p>
            ✉ prodancehalls@mail.ru
        </p>

        <p>
            📍 Санкт-Петербург, ул. Казанская, 7В, 3 этаж
        </p>

    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="toast-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

