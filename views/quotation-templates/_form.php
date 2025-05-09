<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotation-templates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quotation_type_id')->textInput() ?>

    <?= $form->field($model, 'header_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'footer_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'logo_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'background_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'font_family')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default_comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'terms_and_conditions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'show_prices')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
