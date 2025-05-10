<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */

$this->title = 'Cotización #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quotations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
        <?= Html::a('Generar PDF','#', ['class' => 'btn btn-secondary']) ?>
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
                    'id',
                    [
                        'attribute' => 'client_id',
                        'value' => $model->client ? $model->client->name : '',
                    ],
                    [
                        'attribute' => 'quotation_type_id',
                        'value' => $model->quotationType ? $model->quotationType->name : '',
                    ],
                    [
                        'attribute' => 'technician_id',
                        'value' => $model->technician ? $model->technician->name : '',
                    ],
                    [
                        'attribute' => 'status_id',
                        'value' => $model->status ? $model->status->name : '',
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
                'columns' => [
                    [
                        'attribute' => 'service_id',
                        'value' => function ($model) {
                            return $model->service ? $model->service->name : '';
                        },
                    ],
                    'quantity',
                    'unit_price',
                    'subtotal',
                ],
            ]) ?>
        </div>
    </div>

</div>
