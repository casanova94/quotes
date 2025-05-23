<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceOrder */

$this->title = 'Crear Orden de Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Órdenes de Servicio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-order-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 