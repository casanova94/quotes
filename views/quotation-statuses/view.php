<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\QuotationStatuses $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Estados de cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quotation-statuses-view">


    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Desea eliminar este estado?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           //'id',
            'name',
            [
                'label' => 'Color',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div style="width: 60px; height: 25px; background-color:' . $model->color_code . '; border: 1px solid #ccc;"></div>';
                },
            ],
        ],
    ]) ?>

</div>
