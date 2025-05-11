<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Technicians $model */

$this->title = 'Agregar técnico';
$this->params['breadcrumbs'][] = ['label' => 'Técnicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="technicians-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
