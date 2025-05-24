<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\helpers\UserHelper;

/** @var yii\web\View $this */
/** @var app\models\ServiceOrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Órdenes de Servicio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-orders-index">

    <p class="text-right">
        <?= Html::a('Crear Orden de Servicio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'quotation_id',
                    'value' => function ($model) {
                        return $model->quotation ? str_pad($model->quotation->id, 6, '0', STR_PAD_LEFT) . ' - ' . $model->quotation->name : '';
                    },
                    'label' => 'Cotización'
                ],
                [
                    'attribute' => 'technician_id',
                    'value' => 'technician.name',
                    'label' => 'Técnico'
                ],
                'status',
                'creation_date:date',
                'scheduledDateTime:datetime',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}' . (UserHelper::isAdmin() ? ' {delete}' : ''),
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-eye"></i>', $url, [
                                'title' => 'Ver',
                                'class' => 'btn btn-xs btn-primary',
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
                    ],
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div> 