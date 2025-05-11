<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */

$this->title = 'Agregar formato';
$this->params['breadcrumbs'][] = ['label' => 'Formatos de cotización', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-templates-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
