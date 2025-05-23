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

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quotation_type_id')->dropDownList(
        ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un tipo de cotización']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
