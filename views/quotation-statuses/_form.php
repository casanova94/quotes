<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput

/** @var yii\web\View $this */
/** @var app\models\QuotationStatuses $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotation-statuses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= '<label class="control-label">Color del estado</label>';
    echo ColorInput::widget([
        'model' => $model,
        'attribute' => 'color_code',
        'options' => ['placeholder' => 'Select color ...']
    ]) ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>