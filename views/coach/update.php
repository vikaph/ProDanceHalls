<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coach $model */

$this->title = 'Изменить данные тренера: ' . $model->id_coach;
$this->params['breadcrumbs'][] = ['label' => 'Coaches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_coach, 'url' => ['view', 'id_coach' => $model->id_coach]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coach-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
