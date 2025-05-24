<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */

$this->title = 'Cotización #' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quotations-view">

    <p> 
        <?= Html::a('Generar cotización', ['generate-pdf', 'id' => $model->id], ['class' => 'btn btn-secondary', 'target' => '_blank']) ?>
        <?= Html::a('Crear Orden de Servicio', ['service-orders/create', 'quotation_id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta cotización?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Cotización</h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'label' => 'Folio',
                        'value' => function ($model) {
                            return '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
                        },
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'Nombre',
                    ],
                    [
                        'attribute' => 'client_id',
                        'format' => 'raw', // Permitir HTML en el valor
                        'value' => $model->client ? Html::a(
                            $model->client->name,
                            ['clients/view', 'id' => $model->client->id],
                            ['class' => 'btn btn-link px-0 mx-0']
                        ) : '',
                    ],
                    [
                        'label' => 'Dirección',
                        'value' => $model->client->address
                    ],
                    [
                        'attribute' => 'quotation_type_id',
                        'value' => $model->quotationType ? $model->quotationType->name : '',
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $statusColors = [
                                'Creada' => 'info',
                                'Aceptada' => 'success',
                                'Rechazada' => 'danger'
                            ];
                            $color = $statusColors[$model->status] ?? 'secondary';
                            return "<span class='badge badge-{$color}'>{$model->status}</span>";
                        },
                    ],
                    'total_amount',
                    'custom_footer:ntext',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Detalles de la Cotización</h3>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->getQuotationDetails(),
                ]),
                'showFooter' => true, // Mostrar el pie de tabla
                'columns' => [
                    [
                        'attribute' => 'service_id',
                        'value' => function ($model) {
                            return $model->service ? $model->service->name : '';
                        },
                    ],
                    'description',
                    'quantity',
                    [
                        'attribute' => 'unit_price',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asCurrency($model->unit_price);
                        },
                    ],
                    [
                        'attribute' => 'subtotal',
                        'footer' => Yii::$app->formatter->asCurrency(
                            $model->getQuotationDetails()->sum('subtotal')
                        ), // Calcular el total de la columna "subtotal"
                    ]
                ],
            ]) ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Órdenes de Servicio Asociadas</h3>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->getServiceOrders(),
                ]),
                'columns' => [
                    [
                        'attribute' => 'id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a('#' . str_pad($model->id, 6, '0', STR_PAD_LEFT), 
                                ['service-orders/view', 'id' => $model->id],
                                ['class' => 'btn btn-link px-0 mx-0']
                            );
                        },
                        'label' => 'Folio',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $statusColors = [
                                'Pendiente' => 'warning',
                                'En proceso' => 'info',
                                'Finalizado' => 'success',
                                'Cancelado' => 'danger'
                            ];
                            $color = $statusColors[$model->status] ?? 'secondary';
                            return "<span class='badge badge-{$color}'>{$model->status}</span>";
                        },
                    ],
                    [
                        'attribute' => 'technician_id',
                        'value' => function ($model) {
                            return $model->technician ? $model->technician->name : 'No asignado';
                        },
                        'label' => 'Técnico',
                    ],
                    'scheduledDateTime',
                ],
            ]) ?>
        </div>
    </div>

</div>
