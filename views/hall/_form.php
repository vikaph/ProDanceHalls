<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Hall $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="hall-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ->label('Название')?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ->label('Описание')?>

    <?= $form->field($model, 'foto')->textInput(['maxlength' => true]) ->label('Фото')?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ->label('Цена за час')?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ->label('Размер')?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn lesson-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
