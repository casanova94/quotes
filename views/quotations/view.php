<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */

$this->title = '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quotations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Desea eliminar esta cotización?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute' => 'client.name',
                'label' => 'Nombre del cliente',
            ],
            [
                'attribute' => 'client.address',
                'label' => 'Dirección',
            ],
            [
                'attribute' => 'quotationType.name',
                'label' => 'Tipo de cotización',
            ],
            [
                'attribute' => 'technician.name',
                'label' => 'Técnico',
            ],
            [
                'attribute' => 'status.name',
                'label' => 'Estado',
            ],
            'total_amount',
            //'custom_footer:ntext',
            'created_at',
           // 'updated_at',
        ],
    ]) ?>

</div>
