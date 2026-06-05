<?php


use yii\web\Controller;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вход в личный кабинет';
?>

<div class="site-login">

    <h1 class="section-title">
        Вход в личный кабинет
    </h1>

    <p class="section-subtitle">
        Для входа в личный кабинет введите логин и пароль
    </p>
<?php if (Yii::$app->session->hasFlash('success')): ?>

    <div class="toast-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>

<?php endif; ?>
    <div class="login-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>

        <?= $form->field($model, 'login')
            ->textInput([
                'autofocus' => true,
                'class' => 'form-input'
            ])
            ->label('Логин') ?>

        <div class="password-wrapper">

    <?= $form->field($model, 'password')
        ->passwordInput([
            'class' => 'form-input',
            'id' => 'password-input'
        ])
        ->label('Пароль') ?>

    <button type="button"
            class="show-password-btn"
            onclick="togglePassword()">

        👁

    </button>

    </div>

        <?= $form->field($model, 'rememberMe')
            ->checkbox()
            ->label('Запомнить меня') ?>

        <div class="form-group center-btn">

            <?= Html::submitButton(
                'Войти',
                [
                    'class' => 'lesson-btn',
                    'name' => 'login-button'
                ]
            ) ?>

        </div>

        <?php ActiveForm::end(); ?>

        <div class="login-register">
            <?= Html::a(
                'Еще не зарегистрированы? Регистрация',
                ['user/create']
            ) ?>
        </div>

    </div>

</div>

<script>

function togglePassword() {

    let input = document.getElementById('password-input');

    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }

}

</script>