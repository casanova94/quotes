<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationStatuses $model */

$this->title = 'Actualizar estado: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Estados de cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="quotation-statuses-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
