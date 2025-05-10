<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Formatos de cotización', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quotation-templates-view">

    <h1 class="d-none"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Deseas aliminar este formato?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'quotationType.name',
            [
                'attribute' => 'header_text',
                'format' => 'html', // Cambiado de ntext a html
            ],
            [
                'attribute' => 'footer_text',
                'format' => 'html', // Cambiado de ntext a html
            ],
            [
                'attribute' => 'logo_url',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->logo_url ? Html::img(Yii::getAlias('@web') . '/' . $model->logo_url, ['width' => '100px']) : 'No hay logo';
                },
            ],
            [
                'label' => 'Color de fondo',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div style="width: 40px; height: 25px; background-color:' . $model->background_color . '; border: 1px solid #ccc;"></div>';
                },
            ],
            'font_family',
            [
                'attribute' => 'default_comments',
                'format' => 'html', // Cambiado de ntext a html
            ],
            [
                'attribute' => 'terms_and_conditions',
                'format' => 'html', // Cambiado de ntext a html
            ],
            [
                'attribute'=> 'show_prices',
                'label' => 'Mostrar precios',
                'format' => 'raw', // para que no escape el texto
                'value' => function ($model) {
                    return $model->show_prices ? 'Sí' : 'No';
                },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
