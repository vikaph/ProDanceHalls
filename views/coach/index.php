<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Тренеры';

$models = $dataProvider->getModels();
?>

<div class="coach-index container py-5">

    <h1 class="section-title">Тренеры</h1>

    <p class="section-subtitle">
        Команда профессиональных педагогов, которые помогут тебе раскрыть свой стиль и потенциал в танце
    </p>

    <div class="row">

        <?php foreach ($models as $coach): ?>
            <div class="col-md-4 mb-4">

                <!-- карточка тренера -->
                <a href="<?= Url::to(['coach/view', 'id_coach' => $coach->id_coach]) ?>"
                   class="text-decoration-none text-dark">

                    <div class="card coach-card h-100">

                        <!-- фото -->
                        <img src="<?= Yii::getAlias('@web/images/coaches/') . $coach->foto ?>"
                             class="card-img-top coach-img"
                             alt="<?= $coach->fio ?>">

                        <div class="card-body text-center">

                            <!-- ФИО -->
                            <h5 class="card-title mb-2">
                                <?= $coach->fio ?>
                            </h5>

                            <!-- направление -->
                            <p class="text-muted mb-0">
                                <?= $coach->danceDirection->name ?>
                            </p>

                        </div>

                    </div>

                </a>

            </div>
        <?php endforeach; ?>

    </div>

</div>