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
                'attribute' => 'statusName',
                'value' => function ($model) {
                    $status = $model->status;
                    if ($status) {
                        $color = $status->color_code ?: '#000'; // Usar el color guardado o negro por defecto
                        return "<span style='color: {$color}; font-weight: bold;'>{$status->name}</span>";
                    }
                    return 'Desconocido';
                },
                'format' => 'raw', // Permitir HTML en el valor
                'label' => 'Estado',
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
                    'template' => '{custom} {view} {update} {delete} ', // puedes agregar o quitar botones
                    'buttons' => [
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
                                 'title' => 'Generar PDF',
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
