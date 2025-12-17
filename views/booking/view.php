<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Bookings $model */

$this->title = $model->id_booking;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bookings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_booking' => $model->id_booking], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_booking' => $model->id_booking], [
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
            'id_booking',
            'user_id',
            'hall_id',
            'date',
            'time_slot',
            'status',
            'created_booking',
        ],
    ]) ?>

</div>
