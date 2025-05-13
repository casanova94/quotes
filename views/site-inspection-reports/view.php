<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReports $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reportes de Inspección', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="site-inspection-reports-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de que desea eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'quotation_id',
            'technician_id',
            'inspection_date',
            'device_condition_notes:ntext',
            'created_at',
        ],
    ]) ?>

    <h3>Observaciones Relacionadas</h3>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => $model->getObservations(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                'description:ntext',
                [
                    'attribute' => 'photo_url',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->photo_url ? Html::a('Ver Foto', $model->photo_url, ['target' => '_blank']) : 'Sin Foto';
                    },
                ],
            ],
        ]); ?>
    </div>

</div>
