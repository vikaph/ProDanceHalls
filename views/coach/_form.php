<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Coach $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="coach-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ->label('ФИО')?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ->label('Описание')?>

    <?= $form->field($model, 'dance_direction_id')->textInput() ->label('ID танцевального направления') ?>

    <?= $form->field($model, 'foto')->textInput(['maxlength' => true]) ->label('Фото')?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn lesson-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
