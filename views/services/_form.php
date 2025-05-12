<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\QuotationTypes;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Services $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) // Nuevo campo para la descripción ?>

    <?= $form->field($model, 'unit')->dropDownList([
        'Día' => 'Día',
        'Equipo' => 'Equipo',
        'Hora' => 'Hora',
        'Instalación' => 'Instalación',
        'Metro' => 'Metro',
        'Metro cuadrado' => 'Metro cuadrado',
        'Metro cúbico' => 'Metro cúbico',
        'Pieza' => 'Pieza',
        'Reparación' => 'Reparación',
        'Servicio' => 'Servicio',
        'Viaje' => 'Viaje',
    ], ['prompt' => 'Seleccione una unidad']) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?= $form->field($model, 'quotation_type_id')->dropDownList(
        ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un tipo de cotización']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
