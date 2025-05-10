<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */
/** @var app\models\QuotationDetails[] $details */

$this->title = 'Crear Cotización';
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotations-create">

    <h1 class="text-center my-5"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>

</div>
