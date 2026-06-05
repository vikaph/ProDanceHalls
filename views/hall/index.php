<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Аренда танцевального зала';

$models = $dataProvider->getModels();
?>

<div class="hall-index container py-5">

    <h1 class="section-title">Аренда танцевального зала</h1>

    <p class="section-subtitle">
        Выбирай пространство, которое подходит именно тебе.
        У нас есть залы для тренировок, съёмок и мероприятий любого уровня
    </p>

    <div class="row">

        <?php foreach ($models as $hall): ?>
            <div class="col-md-4 mb-4">

                <!-- карточка -->
                <a href="<?= Url::to(['hall/view', 'id_hall' => $hall->id_hall]) ?>"
                   class="text-decoration-none text-dark">

                    <div class="card hall-card h-100">

                        <!-- фото -->
                        <img src="<?= Yii::getAlias('@web/images/halls/') . $hall->foto ?>"
                             class="card-img-top hall-img">

                        <div class="card-body">

                            <!-- название -->
                            <h5 class="card-title text-center">
                                <?= $hall->title ?>
                            </h5>

                            <!-- характеристики -->
                            <p class="text-center mb-1">
                                Площадь: <?= $hall->size ?> м²
                            </p>

                            <p class="text-center fw-bold">
                                <?= $hall->price ?> ₽ / час
                            </p>

                            <!-- кнопка -->
                            <div class="text-center mt-3">
                                <a href="<?= Url::to(['hall/booking', 'id' => $hall->id_hall]) ?>"
                                   class="btn btn-dark rounded-pill px-4">
                                    Забронировать
                                </a>
                            </div>

                        </div>

                    </div>

                </a>

            </div>
        <?php endforeach; ?>

    </div>

</div>