<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Clients;
use app\models\QuotationTypes;
use app\models\Technicians;
use app\models\QuotationStatuses;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_id')->dropDownList(
        ArrayHelper::map(Clients::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un cliente']
    ) ?>

    <?= $form->field($model, 'quotation_type_id')->dropDownList(
        ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un tipo de cotización']
    ) ?>

    <?= $form->field($model, 'technician_id')->dropDownList(
        ArrayHelper::map(Technicians::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un técnico']
    ) ?>

    <?= $form->field($model, 'status_id')->dropDownList(
        ArrayHelper::map(QuotationStatuses::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un estado']
    ) ?>

    <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom_footer')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
