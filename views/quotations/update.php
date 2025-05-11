<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */
/** @var app\models\QuotationDetails[] $details */

$this->title = 'Actualizar Cotización #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Cotización #' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="quotations-update">


    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>

</div>
