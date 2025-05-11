<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */

$this->title = 'Actualizar formato: ' . $model->quotationType->name;
$this->params['breadcrumbs'][] = ['label' => 'Formatos de cotización', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->quotationType->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="quotation-templates-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
