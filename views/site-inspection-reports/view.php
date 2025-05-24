<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReports $model */

$this->title = '#'.str_pad($model->id, 6, '0', STR_PAD_LEFT).' - '.$model->serviceOrder->quotation->name;
$this->params['breadcrumbs'][] = ['label' => 'Reportes de Inspección', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="site-inspection-reports-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar este reporte?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute' => 'service_order_id',
                'format' => 'html',
                'value' => function($model) {
                    return $model->serviceOrder ? Html::a('#'.str_pad($model->serviceOrder->id, 6, '0', STR_PAD_LEFT).' - '.$model->serviceOrder->quotation->name, ['service-orders/view', 'id' => $model->serviceOrder->id]            ) : '';
                }
            ],
            'technician.name',
            'inspection_date',
            'device_condition_notes:ntext',
            'created_at',
        ],
    ]) ?>

    <h3>Observaciones Relacionadas</h3>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => $model->getObservations(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'description:ntext',
               
            ],
        ]); ?>
    </div>

</div>
