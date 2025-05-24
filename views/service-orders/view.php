<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\components\helpers\UserHelper;

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
        <?php if (UserHelper::isAdmin()): ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Está seguro que desea eliminar esta orden de servicio?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Orden de Servicio</h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    [
                        'attribute' => 'quotation_id',
                        'value' => function ($model) {
                            return $model->quotation ? str_pad($model->quotation->id, 6, '0', STR_PAD_LEFT) . ' - ' . $model->quotation->name : '';
                        },
                        'label' => 'Cotización'
                    ],
                    'technician.name',
                    'status',
                    'notes',
                    'creation_date:date',
                    'scheduledDateTime:datetime',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Información del Cliente</h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model->quotation->client,
                'attributes' => [
                    'name',
                    'phone',
                    'address',
                    'email',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Detalles de la orden de servicio</h3>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->quotation->getQuotationDetails()
                ]),
               // 'showFooter' => true, // Mostrar el pie de tabla
                'columns' => [
                    [
                        'attribute' => 'service_id',
                        'value' => function ($model) {
                            return $model->service ? $model->service->name : '';
                        },
                    ],
                    'description',
                    'quantity',
                ],
            ]) ?>
        </div>
    </div>
</div> 