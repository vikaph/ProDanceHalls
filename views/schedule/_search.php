<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ScheduleSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_schedule') ?>

    <?= $form->field($model, 'dance_direction_id') ?>

    <?= $form->field($model, 'coach_id') ?>

    <?= $form->field($model, 'lesson_date') ?>

    <?= $form->field($model, 'lesson_time') ?>

    <?php // echo $form->field($model, 'hall_id') ?>

    <?php // echo $form->field($model, 'max_people') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
