<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DanceDirection $model */

$this->title = 'Изменить данные направления: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dance Directions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id_dance_direction' => $model->id_dance_direction]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dance-direction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
