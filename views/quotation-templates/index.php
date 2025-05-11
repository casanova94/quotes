<?php

use app\models\QuotationTemplates;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\QuotationTemplatesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Formatos de cotización';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-templates-index">

    
    <p class="text-right">
        <?= Html::a('Agregar formato', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            [
                'attribute' => 'quotationTypeName',
                'value' => 'quotationType.name',
                'label' => 'Tipo'
            ],
            //'background_color',
            //'font_family',
            //'default_comments:ntext',
            //'terms_and_conditions:ntext',
            //'show_prices',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, QuotationTemplates $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
