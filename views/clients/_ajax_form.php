<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'client-form',
    'enableAjaxValidation' => false, // Deshabilitar validación AJAX
    'action' => ['clients/create-from-quotation'], 
]); ?>

<?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::class, [
        'clientOptions' => [
            'alias' => 'email', // Máscara para email
        ],
    ]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '999 999 9999', // Máscara para teléfono
        'options' => [
            'placeholder' => 'Ejemplo: 123 456 7890',
        ],
    ]) ?>

<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>




<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>