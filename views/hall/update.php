<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Hall $model */

$this->title = 'Изменить данные зала: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Halls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id_hall' => $model->id_hall]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hall-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
