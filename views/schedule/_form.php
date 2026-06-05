<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Schedule $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dance_direction_id')->textInput() ->label('ID танцевального направления')?>

    <?= $form->field($model, 'coach_id')->textInput() ->label('ID тренера')?>

    <?= $form->field($model, 'lesson_date')->textInput() ->label('Дата занятия')?>

    <?= $form->field($model, 'lesson_time')->textInput() ->label('Время занятия')?>

    <?= $form->field($model, 'hall_id')->textInput() ->label('ID зала')?>

    <?= $form->field($model, 'max_people')->textInput() ->label('Максимальное количество людей')?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn lesson-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
