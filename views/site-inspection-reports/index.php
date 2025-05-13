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
$this->params['breadcrumbs'][] = 'Reportes de Inspección';
?>
<div class="site-inspection-reports-index">


    <p>
        <?= Html::a('Crear Reporte', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'quotation_id',
            'technician_id',
            'inspection_date',
            'device_condition_notes:ntext',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SiteInspectionReports $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
