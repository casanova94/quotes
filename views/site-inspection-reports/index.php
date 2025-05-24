<?php

use app\models\SiteInspectionReports;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReportsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reportes de Inspección';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-inspection-reports-index">

    <p>
        <?= Html::a('Crear Reporte de Inspección', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute' => 'service_order_number',
                'label' => 'Orden de Servicio',
                'value' => function($model) {
                    return $model->serviceOrder ? str_pad($model->serviceOrder->id, 6, '0', STR_PAD_LEFT)    : '';
                }
            ],
            [
                'attribute' => 'technician_name',
                'value' => 'technician.name',
                'label' => 'Técnico',
            ],
            'inspection_date',
            'device_condition_notes:ntext',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
