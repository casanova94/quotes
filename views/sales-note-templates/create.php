<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesNoteTemplates */

$this->title = 'Crear Template de Nota de Venta';
$this->params['breadcrumbs'][] = ['label' => 'Templates de Notas de Venta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-note-templates-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 