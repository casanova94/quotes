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

    <?= $form->field($model, 'quotation_type_id')->dropDownList(
        ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un tipo de cotización']
    ) ?>

    <?= $form->field($model, 'header_text')->widget(Summernote::class, [
        'options' => ['rows' => 6],
        'pluginOptions' => [
            'lang' => 'es-ES', // Configurar el idioma a español
            'height' => 150, // Altura del editor
            'toolbar' => [
                ['style', ['bold', 'italic', 'underline', 'clear']], // Negritas, cursivas, subrayado
                ['para', ['ul', 'ol', 'paragraph']], // Listas y párrafos
                ['fontsize', ['fontsize']], // Tamaño de fuente
                ['color', ['color']], // Colores de texto
                ['insert', ['link']], // Enlaces
                ['view', ['fullscreen', 'codeview']], // Vista completa y código fuente
                ['align', ['alignleft', 'aligncenter', 'alignright', 'alignjustify']], // Alineación
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'footer_text')->widget(Summernote::class, [
        'options' => ['rows' => 6],
        'pluginOptions' => [
            'lang' => 'es-ES', // Configurar el idioma a español
            'height' => 150,
            'toolbar' => [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']],
                ['align', ['alignleft', 'aligncenter', 'alignright', 'alignjustify']],
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'default_comments')->widget(Summernote::class, [
        'options' => ['rows' => 6],
        'pluginOptions' => [
            'lang' => 'es-ES', // Configurar el idioma a español
            'height' => 150,
            'toolbar' => [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']],
                ['align', ['alignleft', 'aligncenter', 'alignright', 'alignjustify']],
            ],
        ],
    ]) ?>

<?= $form->field($model, 'terms_and_conditions')->textarea([
    'rows' => 6,
    'placeholder' => 'Ingrese los términos y condiciones aquí...',
]) ?>

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

    <?= '<label class="control-label">Color de fondo</label>';
    echo ColorInput::widget([
        'model' => $model,
        'attribute' => 'background_color',
        'options' => ['placeholder' => 'Select color ...']
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

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php


$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/lang/summernote-es-ES.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);

?>