<?php

use app\models\Quotations;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\QuotationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
use yii\jui\DatePicker;

$this->title = 'Cotizaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Cotización', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'id',
                'label' => 'Folio',
                'value' => function ($model) {
                    return '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
                },
                'filter' => Html::input('text', 'QuotationsSearch[id]', $searchModel->id, ['class' => 'form-control']),
            ],
            
            [
                'attribute' => 'clientName',
                'value' => 'client.name', 
                'label' => 'Cliente',
            ],
            [
                'attribute' => 'quotationTypeName',
                'value' => 'quotationType.name',
                'label' => 'Tipo'
            ],
            [
                'attribute' => 'technicianName',
                'value' => 'technician.name', 
                'label' => 'Técnico',
            ],
            [
                'attribute' => 'statusName',
                'value' => 'status.name', 
                'label' => 'Estado',
            ],
            //'total_amount:currency',
            //'custom_footer:ntext',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'es',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]),
            ],
            //'updated_at:datetime',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Quotations $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
