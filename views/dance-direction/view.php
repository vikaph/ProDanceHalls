<?php

use yii\helpers\Html;

/** @var app\models\DanceDirection $model */

$this->title = $model->name;
?>

<div class="direction-view container py-5">

    <div class="row align-items-center">

        <!-- КАРТИНКА -->
        <div class="col-lg-5 text-center mb-4">

            <img src="<?= Yii::getAlias('@web/images/direction/') . $model->image ?>"
                 class="img-fluid direction-image"
                 alt="<?= $model->name ?>">

        </div>

        <!-- ИНФОРМАЦИЯ -->
        <div class="col-lg-7">

            <h1 class="direction-title">
                <?= Html::encode($model->name) ?>
            </h1>

            <div class="direction-line"></div>

            <div class="direction-description">

                <?= nl2br(Html::encode($model->description)) ?>

            </div>

            <div class="mt-5">

                <a href="<?= \yii\helpers\Url::to(['/site/first-class']) ?>"
                   class="btn direction-btn">

                    Записаться на занятие

                </a>

            </div>

        </div>

    </div>

</div>
