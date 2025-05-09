<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\QuotationTypes;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotation-templates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quotation_type_id')->dropDownList(
        ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un tipo de cotización']
    ) ?>

    <?= $form->field($model, 'header_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'footer_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'logo_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'background_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'font_family')->dropDownList([
    'Arial, sans-serif' => 'Arial',
    '"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica',
    '"Times New Roman", Times, serif' => 'Times New Roman',
    'Georgia, serif' => 'Georgia',
    'Tahoma, sans-serif' => 'Tahoma',
    'Verdana, sans-serif' => 'Verdana',
    '"Courier New", Courier, monospace' => 'Courier New',
    '"Lucida Console", Monaco, monospace' => 'Lucida Console',
    '"Trebuchet MS", sans-serif' => 'Trebuchet MS',
    '"Comic Sans MS", cursive, sans-serif' => 'Comic Sans MS',
], ['prompt' => 'Selecciona una fuente']) ?>


    <?= $form->field($model, 'default_comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'terms_and_conditions')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'show_prices')->widget(SwitchInput::class, [
    'pluginOptions' => [
        'onText' => 'Sí',
        'offText' => 'No',
        'onColor' => 'success', // verde
        'offColor' => 'danger', // rojo
    ]
]); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
