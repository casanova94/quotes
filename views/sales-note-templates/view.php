<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SalesNoteTemplates */

$this->title = 'Template de Nota de Venta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Templates de Notas de Venta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sales-note-templates-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar este template?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'quotation_type_id',
                'value' => function($model) {
                    return $model->quotationType ? $model->quotationType->name : '';
                }
            ],
            [
                'attribute' => 'logo',
                'format' => 'html',
                'value' => function($model) {
                    return $model->logo ? Html::img('@web/' . $model->logo, ['style' => 'max-width: 200px;']) : '';
                }
            ],
            [
                'attribute' => 'header_text',
                'format' => 'html',
                'value' => function($model) {
                    return nl2br($model->header_text);
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div> 