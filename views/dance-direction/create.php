<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DanceDirection $model */

$this->title = 'Create Dance Direction';
$this->params['breadcrumbs'][] = ['label' => 'Dance Directions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dance-direction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
