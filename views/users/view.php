<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            <div class="card-tools">
                <?= Html::a('<i class="fas fa-edit"></i> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('<i class="fas fa-trash"></i> Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => '¿Está seguro de eliminar este usuario?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'email:email',
                    [
                        'attribute' => 'role',
                        'value' => function ($model) {
                            return $model->getRole();
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->status == 10 ? 'Activo' : 'Inactivo';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->created_at);
                        },
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->updated_at);
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div> 