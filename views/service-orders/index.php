<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Órdenes de Servicio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-order-index">

    <p class="text-right">
        <?= Html::a('Crear Orden de Servicio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'quotation_id',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->quotation ? ( Html::a(str_pad($model->quotation->id, 6, '0', STR_PAD_LEFT) . ' - ' . $model->quotation->name, ['quotations/view', 'id' => $model->quotation->id], ['class' => 'btn btn-link'])): '';
                }
            ],
            'creation_date',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status ? $model->status : '';
                }
            ],
            'scheduledDateTime',
            [
                'attribute' => 'technician_id',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->technician ? $model->technician->name : '', ['technicians/view', 'id' => $model->technician->id], ['class' => 'btn btn-link']);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div> 