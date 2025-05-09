<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationTypes $model */

$this->title = 'Actualizar tipo: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quotation-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
