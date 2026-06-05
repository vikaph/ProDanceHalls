<?php

use app\models\DanceDirection;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DanceDirectionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Направления';
?>

<?php
$models = $dataProvider->getModels();
?>

<div class="dance-direction-index container py-5">

    <h1 class="section-title">Направления</h1>

    <p class="section-subtitle">
        Выбери своё направление и начни двигаться так, как чувствуешь.
        Танец — это не про идеальность, а про энергию, свободу и тебя настоящего
    </p>

    <!-- КАРТОЧКИ -->
    <div class="row">

        <?php foreach ($models as $model): ?>
            <div class="col-md-4 mb-4">

                <a href="<?= \yii\helpers\Url::to([
                    'dance-direction/view',
                    'id_dance_direction' => $model->id_dance_direction
                ]) ?>" class="text-decoration-none">

                    <div class="card direction-card h-100">

                        <img src="<?= Yii::getAlias('@web/images/direction/') . $model->image ?>"
                             class="card-img-top">

                    </div>

                </a>

            </div>
        <?php endforeach; ?>

    </div>

</div>
