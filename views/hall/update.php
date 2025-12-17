<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Halls $model */

$this->title = 'Update Halls: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Halls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id_hall' => $model->id_hall]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="halls-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
