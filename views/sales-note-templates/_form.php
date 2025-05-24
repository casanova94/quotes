<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use app\models\QuotationTypes;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\SalesNoteTemplates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-note-templates-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos Básicos</h3>
        </div>
        <div class="card-body">

            <?= $form->field($model, 'quotation_type_id')->widget(Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Seleccione un tipo de cotización...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'logoFile')->widget(FileInput::class, [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'initialPreview' => $model->getLogoInitialPreview(),
                    'initialPreviewConfig' => $model->getLogoInitialPreviewConfig(),
                    'initialPreviewAsData' => true,
                    'showPreview' => true,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary',
                    'browseIcon' => '<i class="fas fa-camera"></i> ',
                    'browseLabel' => 'Seleccionar Logo',
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="fas fa-trash"></i> ',
                    'removeLabel' => 'Eliminar',
                    'layoutTemplates' => [
                        'main1' => '{preview}<div class="input-group">{caption}<div class="input-group-append">{remove}{browse}</div></div>',
                    ],
                    'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
                    'maxFileSize' => 2048, // 2MB
                ],
            ]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Texto de Encabezado</h3>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'header_text')->widget(CKEditor::class, [
                'options' => ['rows' => 6],
                'preset' => 'basic'
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    $(document).on('filepredelete', function(event, key, jqXHR, data) {
        var abort = true;
        if (confirm('¿Está seguro que desea eliminar este logo?')) {
            abort = false;
        }
        return abort;
    });
");
?>