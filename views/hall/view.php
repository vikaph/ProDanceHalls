<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Hall $model */

$this->title = $model->title;
?>

<div class="hall-view container py-5">

    <div class="row align-items-start">

        <!-- ФОТО -->
        <div class="col-md-5 text-center">
            <img src="<?= Yii::getAlias('@web/images/halls/') . $model->foto ?>"
                 class="hall-photo"
                 alt="<?= Html::encode($model->title) ?>">
        </div>

        <!-- ИНФО -->
        <div class="col-md-7">

            <h1 class="hall-title">
                <?= Html::encode($model->title) ?>
            </h1>

            <div class="hall-price">
                <?= $model->price ?> ₽ / час
            </div>

            <div class="hall-size">
                Площадь: <?= $model->size ?> м²
            </div>

            <div class="hall-description">
                <?= nl2br(Html::encode($model->description)) ?>
            </div>


            <a href="<?= Url::to(['hall/booking', 'id' => $model->id_hall]) ?>"
                                   class="btn hall-btn">
                                    Забронировать зал
                                </a>
        </div>

    </div>

</div>