<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            <div class="card-tools">
                <?= Html::a('<i class="fas fa-plus"></i> Nuevo Usuario', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'username',
                    'email:email',
                    [
                        'attribute' => 'role',
                        'value' => function ($model) {
                            return $model->getRole();
                        },
                        'filter' => [
                            'admin' => 'Administrador',
                            'technician' => 'Técnico',
                        ],
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->status == 10 ? 'Activo' : 'Inactivo';
                        },
                        'filter' => [
                            10 => 'Activo',
                            9 => 'Inactivo',
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'title' => 'Ver',
                                    'class' => 'btn btn-info btn-sm',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'title' => 'Editar',
                                    'class' => 'btn btn-primary btn-sm',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'title' => 'Eliminar',
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => '¿Está seguro de eliminar este usuario?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div> 