<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="register-wrapper">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')
        ->textInput([
            'maxlength' => true,
            'class' => 'form-input',
            'placeholder' => 'Введите ФИО'
        ])
        ->label('ФИО') ?>

    <?= $form->field($model, 'phone')
    ->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7 (999) 999-99-99',
        'options' => [
            'class' => 'form-input',
            'placeholder' => '+7 (999) 999-99-99'
        ],
    ])
    ->label('Телефон') ?>

    <?= $form->field($model, 'login')
        ->textInput([
            'maxlength' => true,
            'class' => 'form-input',
            'placeholder' => 'Введите логин'
        ])
        ->label('Логин') ?>

   <div class="password-wrapper">

    <?= $form->field($model, 'password')
        ->passwordInput([
            'maxlength' => true,
            'class' => 'form-input password-input',
            'placeholder' => 'Введите пароль',
            'id' => 'password-field'
        ])
        ->label('Пароль') ?>

    <span class="toggle-password" onclick="togglePassword()">
        👁
    </span>

</div>

    <div class="form-group center-btn">

        <?= Html::submitButton(
            'Зарегистрироваться',
            ['class' => 'lesson-btn']
        ) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password-field');

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>