<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bookings $model */

$this->title = 'Update Bookings: ' . $model->id_booking;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_booking, 'url' => ['view', 'id_booking' => $model->id_booking]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bookings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
