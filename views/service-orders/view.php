<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceOrder */

$this->title = 'Orden de Servicio #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Órdenes de Servicio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="service-order-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar esta orden de servicio?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute' => 'quotation_id',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->quotation ? Html::a('Cotización #' . str_pad($model->quotation->id, 6, '0', STR_PAD_LEFT) . ' - ' . $model->quotation->name . ' - ' . $model->quotation->client->name, ['/quotations/view', 'id' => $model->quotation->id], ['class' => 'btn btn-link pl-0 ml-0']) : '';
                }
            ],
            'creation_date',
            'status',
            'notes:ntext',
            'scheduledDateTime',
            [
                'attribute' => 'technician_id',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->technician ? $model->technician->name : '', ['/technicians/view', 'id' => $model->technician_id], ['class' => 'btn btn-link pl-0 ml-0'])   ;
                }
            ],
        ],
    ]) ?>

</div> 