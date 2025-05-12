<?php

use app\models\Clients;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ClientsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">


    <p class="text-right">
        <?= Html::a('Agregar cliente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name',
                'phone',
                'address:ntext',
                //'created_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}', // puedes agregar o quitar botones
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