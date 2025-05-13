<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReportsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="site-inspection-reports-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'quotation_id') ?>

    <?= $form->field($model, 'technician_id') ?>

    <?= $form->field($model, 'inspection_date') ?>

    <?= $form->field($model, 'device_condition_notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reiniciar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
