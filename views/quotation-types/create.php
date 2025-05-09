<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationTypes $model */

$this->title = 'Crear tipo';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
