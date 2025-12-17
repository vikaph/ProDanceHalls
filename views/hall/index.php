<?php

use app\models\Halls;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HallSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Halls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="halls-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Halls', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_hall',
            'title',
            'description:ntext',
            'category_id',
            'price',
            //'foto',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Halls $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_hall' => $model->id_hall]);
                 }
            ],
        ],
    ]); ?>


</div>
