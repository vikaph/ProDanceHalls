<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BookingSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bookings-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_booking') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'hall_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'time_slot') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_booking') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
