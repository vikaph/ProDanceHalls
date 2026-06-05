<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Занятие';
?>

<?php
// проверка прошедшего занятия
$isPast = strtotime($model->lesson_date . ' ' . $model->lesson_time) < time();
?>

<!-- FLASH СООБЩЕНИЯ -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="toast-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('info')): ?>
    <div class="toast-info">
        <?= Yii::$app->session->getFlash('info') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="toast-error">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div class="lesson-card-full">

    <div class="lesson-layout">

        <!-- ЛЕВАЯ ЧАСТЬ -->
        <div class="lesson-image">
            <img src="/images/direction/<?= $model->danceDirection->image ?>" alt="">
        </div>

        <!-- ПРАВАЯ ЧАСТЬ -->
        <div class="lesson-info">

            <h2><?= $model->danceDirection->name ?></h2>

            <p><b>Тренер:</b> <?= $model->coach->fio ?></p>

            <p><b>Описание:</b> <?= $model->danceDirection->description ?></p>

            <p><b>Зал:</b> <?= $model->hall->title ?></p>

            <p><b>Дата:</b> <?= $model->lesson_date ?></p>

            <p><b>Время:</b>
                <?= substr($model->lesson_time, 0, 5) ?>
                -
                <?= date('H:i', strtotime($model->lesson_time . ' +1 hour')) ?>
            </p>

            <p><b>Группа:</b>
                <?= $model->group_type == 'kids'
                    ? 'Детская'
                    : 'Взрослая'
                ?>
            </p>

        </div>

    </div>

</div>

<hr>

<!-- КНОПКА ДЕЙСТВИЯ -->
<div class="lesson-action">

    <?php if (Yii::$app->user->isGuest): ?>

        <a class="lesson-btn" href="<?= Url::to(['site/login']) ?>">
            Войти, чтобы записаться
        </a>

    <?php elseif ($isPast): ?>

        <button class="lesson-btn disabled-btn" disabled>
            Занятие уже прошло 
        </button>

    <?php elseif ($isBooked): ?>

        <button class="lesson-btn disabled-btn" disabled>
            Вы уже записаны 
        </button>

    <?php else: ?>

        <form method="post" action="<?= Url::to(['schedule/enroll']) ?>">

            <!-- CSRF -->
            <?= Html::hiddenInput(
                Yii::$app->request->csrfParam,
                Yii::$app->request->csrfToken
            ) ?>

            <input type="hidden" name="schedule_id" value="<?= $model->id_schedule ?>">

            <button class="lesson-btn">
                Записаться на занятие
            </button>

        </form>

    <?php endif; ?>

</div>