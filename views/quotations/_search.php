<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\QuotationsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'client_id') ?>

    <?= $form->field($model, 'quotation_type_id') ?>

    <?= $form->field($model, 'technician_id') ?>

    <?= $form->field($model, 'status')->dropDownList(
        ['Creada' => 'Creada', 'Aceptada' => 'Aceptada', 'Rechazada' => 'Rechazada'],
        ['prompt' => 'Seleccione un estado']
    ) ?>

    <?php // echo $form->field($model, 'total_amount') ?>

    <?php // echo $form->field($model, 'custom_footer') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
