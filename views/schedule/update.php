<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Schedule $model */

$this->title = 'Изменить данные занятия: ' . $model->id_schedule;
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_schedule, 'url' => ['view', 'id_schedule' => $model->id_schedule]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
