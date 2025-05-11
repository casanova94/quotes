<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\QuotationTypes;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use kartik\color\ColorInput;
use kartik\editors\Summernote;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotation-templates-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Card para datos básicos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos Básicos</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Primera columna: Campos básicos -->
                <div class="col-md-8">
                    <?= $form->field($model, 'quotation_type_id')->dropDownList(
                        ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
                        ['prompt' => 'Seleccione un tipo de cotización']
                    ) ?>

                    <?= '<label class="control-label">Color de fondo</label>';
                    echo ColorInput::widget([
                        'model' => $model,
                        'attribute' => 'background_color',
                        'options' => ['placeholder' => 'Seleccione un color...']
                    ]) ?>

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

                    <?= $form->field($model, 'show_prices')->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'onText' => 'Sí',
                            'offText' => 'No',
                            'onColor' => 'success', // verde
                            'offColor' => 'danger', // rojo
                        ]
                    ]); ?>
                </div>

                <!-- Segunda columna: Campo de logo -->
                <div class="col-md-4">
                    <?= $form->field($model, 'logoFile')->widget(\kartik\file\FileInput::class, [
                        'options' => [
                            'accept' => 'image/*', // Solo aceptar imágenes
                        ],
                        'pluginOptions' => [
                            'initialPreview' => $model->logo_url ? [Yii::getAlias('@web') . '/' . $model->logo_url] : [], // Mostrar preview si ya existe una imagen
                            'initialPreviewAsData' => true, // Mostrar la imagen como preview
                            'overwriteInitial' => true, // Sobrescribir la imagen inicial
                            'showRemove' => true, // Mostrar botón de eliminar
                            'showUpload' => false, // Ocultar botón de subida (se subirá al guardar el formulario)
                            'deleteUrl' => \yii\helpers\Url::to(['quotation-templates/delete-logo', 'id' => $model->id]), // URL para eliminar la imagen
                            'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif'], // Extensiones permitidas
                            'maxFileSize' => 2048, // Tamaño máximo en KB
                            'language' => 'es', // Cambiar el idioma a español
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Card para editores de texto -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Textos Predeterminados</h3>
        </div>
        <div class="card-body">
            <?= \yii\bootstrap4\Tabs::widget([
                'items' => [
                    [
                        'label' => 'Encabezado',
                        'content' => $form->field($model, 'header_text')->widget(\dosamigos\ckeditor\CKEditor::class, [
                            'options' => ['rows' => 6],
                            'preset' => 'basic',
                            'clientOptions' => [
                                'language' => 'es',
                                'height' => 200,
                            ],
                        ]),
                        'active' => true,
                    ],
                    [
                        'label' => 'Pie de Página',
                        'content' => $form->field($model, 'footer_text')->widget(\dosamigos\ckeditor\CKEditor::class, [
                            'options' => ['rows' => 6],
                            'preset' => 'basic',
                            'clientOptions' => [
                                'language' => 'es',
                                'height' => 200,
                            ],
                        ]),
                    ],
                    [
                        'label' => 'Comentarios Predeterminados',
                        'content' => $form->field($model, 'default_comments')->widget(\dosamigos\ckeditor\CKEditor::class, [
                            'options' => ['rows' => 6],
                            'preset' => 'basic',
                            'clientOptions' => [
                                'language' => 'es',
                                'height' => 200,
                            ],
                        ]),
                    ],
                    [
                        'label' => 'Términos y Condiciones',
                        'content' => $form->field($model, 'terms_and_conditions')->widget(\dosamigos\ckeditor\CKEditor::class, [
                            'options' => ['rows' => 6],
                            'preset' => 'basic',
                            'clientOptions' => [
                                'language' => 'es',
                                'height' => 200,
                            ],
                        ]),
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php


$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/lang/summernote-es-ES.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);

$this->registerCss("
    .note-editor {
        margin-bottom: 20px;
    }
");