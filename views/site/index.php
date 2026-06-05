<?php

/** @var yii\web\View $this */

$this->title = 'Танцевальная студия ProDanceHalls';
?>
<div class="site-index">


<div class="hero full-width-hero">

    <!-- ЛЕВАЯ ЧАСТЬ (картинка) -->
    <div class="hero-image">
        <img src="<?= Yii::getAlias('@web/images/banner.png') ?>" alt="ProDanceHalls">
    </div>

    <!-- ПРАВАЯ ЧАСТЬ (текст) -->
    <div class="hero-text">

        <h1>ProDanceHalls</h1>

        <p class="hero-subtitle">
            Танцуй вместе с нами: запишись на пробное занятие или арендуй зал
        </p>

        <!-- 2 кнопки -->
        <div class="hero-buttons">

            <a href="<?= \yii\helpers\Url::to(['/schedule/index']) ?>"
               class="btn btn-yellow">
                Расписание
            </a>

            <a href="<?= \yii\helpers\Url::to(['/hall/index']) ?>"
               class="btn btn-yellow">
                Аренда зала
            </a>

        </div>

        <!-- большая кнопка -->
        <div class="hero-main-btn">
            <a href="<?= \yii\helpers\Url::to(['/site/first-class']) ?>"
               class="btn btn-orange">
                Записаться на занятие
            </a>
        </div>

    </div>

</div>

<!-- НАШИ ПРЕИМУЩЕСТВА -->
<section class="advantages-section">

    <h2 class="advantages-title">Наши преимущества</h2>

    <div class="advantages-grid">

        <div class="advantage-card">
            <img src="<?= Yii::getAlias('@web') ?>/images/advantages/1.png" alt="">
            <p>
                Теплые полы, подсветки, кондиционеры,
                качественное звуковое оборудование
            </p>
        </div>

        <div class="advantage-card">
            <img src="<?= Yii::getAlias('@web') ?>/images/advantages/2.png" alt="">
            <p>
                Комфортные раздевалки
                со шкафчиками и кулерами
            </p>
        </div>

        <div class="advantage-card">
            <img src="<?= Yii::getAlias('@web') ?>/images/advantages/3.png" alt="">
            <p>
                9 просторных хореографических
                залов с разной тематикой
            </p>
        </div>

        <div class="advantage-card">
            <img src="<?= Yii::getAlias('@web') ?>/images/advantages/4.png" alt="">
            <p>
                Большой выбор современных
                танцевальных стилей
            </p>
        </div>

        <div class="advantage-card">
            <img src="<?= Yii::getAlias('@web') ?>/images/advantages/5.png" alt="">
            <p>
                Сильнейшая команда
                хореографов
            </p>
        </div>

    </div>

</section>

        <h2 class="advantages-title">Направления</h2>

<div id="directionCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

        <?php foreach (array_chunk($directions, 3) as $index => $chunk): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="container">
                    <div class="row justify-content-center">

                        <?php foreach ($chunk as $direction): ?>
                            <div class="col-md-4 mb-4">

                                <a href="<?= \yii\helpers\Url::to([
                                    'dance-direction/view',
                                    'id_dance_direction' => $direction->id_dance_direction
                                ]) ?>">

                                    <div class="card direction-card">

                                        <img src="<?= Yii::getAlias('@web/images/direction/') . $direction->image ?>"
                                             class="card-img-top">

                                    </div>

                                </a>

                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- стрелки -->
    <button class="carousel-control-prev" type="button" data-bs-target="#directionCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#directionCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

    </div>
</div>
