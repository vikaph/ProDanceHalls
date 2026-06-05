<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Coach $model */

$this->title = $model->fio;
?>

<div class="coach-view container">

   <div class="row align-items-start">

        <!-- ФОТО -->
        <div class="col-md-4 text-center">
            <img src="<?= Yii::getAlias('@web/images/coaches/') . $model->foto ?>"
                 class="coach-photo"
                 alt="<?= Html::encode($model->fio) ?>">
        </div>

        <!-- ИНФОРМАЦИЯ -->
        <div class="col-md-8">

            <!-- ФИО -->
            <div class="coach-name">
                <?= Html::encode($model->fio) ?>
            </div>

            <!-- НАПРАВЛЕНИЕ -->
            <div class="coach-direction">
                <span>Направление:</span>
                <?= Html::encode($model->danceDirection->name) ?>
            </div>

            <!-- ЛИНИЯ -->
            <div class="coach-line"></div>

            <!-- ОПИСАНИЕ -->
            <div class="coach-description">
                <?= nl2br(Html::encode($model->description)) ?>
            </div>

        </div>

    </div>

    <!-- КНОПКА -->
    <div class="text-center mt-5">

        <p class="mb-2 text-muted">
            Хочешь попасть на тренировку к этому тренеру?
        </p>

        <a href="<?= Url::to(['/site/first-class']) ?>"
           class="btn btn-coach rounded-pill px-5 py-2">
            Записаться на занятие
        </a>

    </div>

</div>