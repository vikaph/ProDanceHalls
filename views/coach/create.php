<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coach $model */

$this->title = 'Добавить тренера';
$this->params['breadcrumbs'][] = ['label' => 'Coaches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coach-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
