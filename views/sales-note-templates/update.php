<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesNoteTemplates */

$this->title = 'Actualizar Template de Nota de Venta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Templates de Notas de Venta', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="sales-note-templates-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 