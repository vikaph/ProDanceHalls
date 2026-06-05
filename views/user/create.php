<?php

use yii\widgets\MaskedInput;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Регистрация';
?>

<div class="user-create">

    <h1 class="section-title">
        Регистрация
    </h1>

    <p class="section-subtitle">
        Создайте аккаунт и записывайтесь на занятия онлайн
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>