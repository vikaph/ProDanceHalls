<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Пробное занятие';
?>

<br><br>

<h1 class="section-title">
    Пробное занятие
</h1>

<p class="section-subtitle">
    Оставь заявку на бесплатное пробное занятие💥
</p>

<div class="trial-wrapper">

    <div class="trial-info">

        <p>
            Мы подберём для тебя направление, расскажем с чего начать и поможем сделать первый шаг в танце максимально комфортно
        </p>

        <p>
            Наш менеджер свяжется с тобой, ответит на все вопросы и запишет на первое занятие
        </p>

    </div>

    <?php $form = ActiveForm::begin([
        'action' => ['site/save-first-class'],
        'options' => ['class' => 'trial-form']
    ]); ?>

        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Ваше имя']) -> label('Имя') ?>

        <?= $form->field($model, 'phone')
        ->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '+7 (999) 999-99-99',
            'options' => [
                'class' => 'form-input',
                'placeholder' => '+7 (999) 999-99-99'
            ],
        ])
        ->label('Телефон') ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить заявку', ['class' => 'lesson-btn']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<br>
<br>