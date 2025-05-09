<?php

use app\models\QuotationStatuses;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\QuotationStatusesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estados de cotizaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-statuses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Agregar estado', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
            [
                'attribute' => 'color_code',
                'format' => 'raw',
                'label' => 'Color',
                'filter' => false, 
                'value' => function ($model) {
                    return '<div style="width: 30px; height: 20px; background-color:' . $model->color_code . '; border: 1px solid #ccc;"></div>';
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, QuotationStatuses $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
