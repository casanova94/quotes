<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

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
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Desea eliminar a este técnico?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


     <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del técnico</h3>
        </div>
        <div class="card-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'phone',
            'email:email',
        ],
    ]) ?></div></div>

     <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Servicios asignados</h3>
        </div>
         <div class="card-body">
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider( ['query' =>  $model->getQuotations()]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'label' => 'Folio',
                    'value' => function ($model) {
                        return '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
                    },
                ],
                'status.name:text:Estado',
                [
                    'attribute' => 'quotation_type_id',
                    'value' => function ($model) {
                        return $model->quotationType ? $model->quotationType->name : '';
                    },
                ],
                [
                    'attribute' => 'client_id',
                    'format' => 'raw', // Permitir HTML en el valor
                    'value' => function ($model) {
                        return $model->client ? Html::a(
                            $model->client->name,
                            ['clients/view', 'id' => $model->client->id],
                            ['class' => 'btn btn-link px-0 mx-0']
                        ) : '';
                    },
                ],
                'created_at:date',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-eye"></i>', ['quotations/view', 'id' => $model->id], [
                                'title' => 'Ver Cotización',
                                'class' => 'btn btn-primary btn-sm',
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div></div>
</div>
</div>
