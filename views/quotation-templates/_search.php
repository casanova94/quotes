<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplatesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotation-templates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'quotation_type_id') ?>

    <?= $form->field($model, 'header_text') ?>

    <?= $form->field($model, 'footer_text') ?>

    <?= $form->field($model, 'logo_url') ?>

    <?php // echo $form->field($model, 'background_color') ?>

    <?php // echo $form->field($model, 'font_family') ?>

    <?php // echo $form->field($model, 'default_comments') ?>

    <?php // echo $form->field($model, 'terms_and_conditions') ?>

    <?php // echo $form->field($model, 'show_prices') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
