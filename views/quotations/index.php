<?php

use app\models\Quotations;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\QuotationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
use yii\jui\DatePicker;

$this->title = 'Cotizaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotations-index">

    <p  class="text-right">
        <?= Html::a('Crear Cotización', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
      <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'label' => 'Folio',
                'value' => function ($model) {
                    return '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
                },
                'filter' => Html::input('text', 'QuotationsSearch[id]', $searchModel->id, ['class' => 'form-control']),
                'headerOptions' => ['style' => 'width: 100px;'], // Ancho del encabezado
            ],
            [
                'attribute' => 'name',
                'value' => 'name', 
                'label' => 'Nombre',
            ],
            [
                'attribute' => 'clientName',
                'value' => 'client.name', 
                'label' => 'Cliente',
            ],
            [
                'attribute' => 'quotationTypeName',
                'value' => 'quotationType.name',
                'label' => 'Tipo',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    $statusColors = [
                        'Creada' => 'info',
                        'Aceptada' => 'success',
                        'Rechazada' => 'danger'
                    ];
                    $color = $statusColors[$model->status] ?? 'secondary';
                    return "<span class='badge badge-{$color}'>{$model->status}</span>";
                },
                'format' => 'raw',
                'label' => 'Estado',
                'filter' => Html::dropDownList(
                    'QuotationsSearch[status]',
                    $searchModel->status,
                    ['Creada' => 'Creada', 'Aceptada' => 'Aceptada', 'Rechazada' => 'Rechazada'],
                    ['class' => 'form-control', 'prompt' => 'Seleccione un estado']
                ),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'es',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]),
            ],
            [
                'headerOptions' => ['style' => 'width: 130px;'], // Ancho del encabezado,
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create-order} {custom} {view} {update} {delete} ', // puedes agregar o quitar botones
                'buttons' => [
                    'create-order' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-clipboard-list"></i>', ['service-orders/create', 'quotation_id' => $model->id], [
                            'title' => 'Crear Orden de Servicio',
                            'class' => 'btn btn-xs btn-info mt-3 mt-md-0',
                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'title' => 'Ver',
                                    'class' => 'btn btn-xs btn-primary mt-3 mt-md-0',
                                ]);
                            },
                    'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'title' => 'Actualizar',
                                    'class' => 'btn btn-xs btn-warning mt-3 mt-md-0',
                                ]);
                            },
                    'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'title' => 'Eliminar',
                                    'class' => 'btn btn-xs btn-danger mt-3 mt-md-0',
                                    'data-confirm' => '¿Estás seguro de que deseas eliminar este elemento?',
                                    'data-method' => 'post',
                                ]);
                            },
                     'custom' => function ($url, $model, $key) {
                         return Html::a('<i class="fas fa-file-pdf"></i>', ['quotations/generate-pdf', 'id' => $model->id], [
                             'title' => 'Generar cotización',
                             'data-pjax' => '0',
                             'class' => 'btn btn-xs btn-danger mt-3 mt-md-0',
                         ]);
                     }
                ],
            ],
        ],
    ]); ?>
</div>
    <?php Pjax::end(); ?>

</div>
