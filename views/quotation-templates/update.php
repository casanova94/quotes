<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */

$this->title = 'Actualizar formato: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Formatos de cotización', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="quotation-templates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
