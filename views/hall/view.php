<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Halls $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Halls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="halls-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_hall' => $model->id_hall], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_hall' => $model->id_hall], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_hall',
            'title',
            'description:ntext',
            'category_id',
            'price',
            'foto',
        ],
    ]) ?>

</div>
