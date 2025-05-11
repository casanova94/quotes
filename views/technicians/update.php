<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Technicians $model */

$this->title = 'Actualizar técnico: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Técnicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="technicians-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
