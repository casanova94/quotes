<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesNoteTemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Templates de Notas de Venta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-note-templates-index">

    <p class="text-right">
        <?= Html::a('Crear Template', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute' => 'quotation_type_id',
                'value' => function($model) {
                    return $model->quotationType ? $model->quotationType->name : '';
                }
            ],
            'header_text:ntext',
            'company_text:ntext',
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div> 