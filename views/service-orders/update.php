<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceOrder */

$this->title = 'Actualizar Orden de Servicio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Órdenes de Servicio', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="service-order-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 