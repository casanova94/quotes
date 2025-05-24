<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\components\helpers\UserHelper;

/** @var yii\web\View $this */
/** @var app\models\Technicians $model */
/** @var yii\data\ActiveDataProvider $quotationsDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Técnicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="technicians-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Actualizar Contraseña', ['update-password', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?php if (UserHelper::isAdmin()): ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Desea eliminar a este técnico?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información Personal</h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'phone',
                    'email:email',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Información de Acceso</h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model->user,
                'attributes' => [
                    'username',
                    'email:email',
                    'status:boolean',
                    'created_at:datetime',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Ordenes de servicio</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getServiceOrders()]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Cotización',
                            'value' => function ($model) {
                                return $model->quotation ? Html::a(str_pad($model->quotation->id, 6, '0', STR_PAD_LEFT).' - '. $model->quotation->name . ' - ' . $model->quotation->client->name, ['quotations/view', 'id' => $model->quotation->id], ['class' => 'btn btn-link']) : '';
                            },
                            'format' => 'raw',
                        ],
                        'status',
                        'creation_date:date',
                        'scheduledDateTime:datetime',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="fas fa-eye"></i>', ['service-orders/view', 'id' => $model->id], [
                                        'title' => 'Ver Orden de servicio',
                                        'class' => 'btn btn-primary btn-sm',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
