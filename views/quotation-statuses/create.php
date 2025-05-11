<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationStatuses $model */

$this->title = 'Agregar estado';
$this->params['breadcrumbs'][] = ['label' => 'Estados de cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-statuses-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
