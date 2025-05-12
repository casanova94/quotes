<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Clients;
use app\models\QuotationTypes;
use app\models\Technicians;
use app\models\QuotationStatuses;
use app\models\Services;
use yii\bootstrap4\Modal; 

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */
/** @var app\models\QuotationDetails[] $details */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotations-form">
    <?php $form = ActiveForm::begin(['id' => 'quotation-form']); ?>

     <div class="card mt-3">

  <div class="card-header d-flex align-items-center">
    <h3 class="card-title mb-0">Datos Generales</h3>
    <button type="button" class="btn btn-sm btn-success ml-auto" data-toggle="modal" data-target="#createClientModal">
        Nuevo cliente
    </button>
</div>

        <div class="card-body">
             <div class="row">
        <div class="col-md-4">
           <div class="form-group field-quotation-client_id">
    <?= $form->field($model, 'client_id')->dropDownList(
        ArrayHelper::map(Clients::find()->all(), 'id', 'name'),
        ['prompt' => 'Seleccione un cliente']
    ) ?>

</div>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'quotation_type_id')->dropDownList(
                ArrayHelper::map(QuotationTypes::find()->all(), 'id', 'name'),
                ['prompt' => 'Seleccione un tipo de cotización']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'technician_id')->dropDownList(
                ArrayHelper::map(Technicians::find()->all(), 'id', 'name'),
                ['prompt' => 'Seleccione un técnico']
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'status_id')->dropDownList(
                ArrayHelper::map(QuotationStatuses::find()->all(), 'id', 'name'),
                ['prompt' => 'Seleccione un estado']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true, 'readonly' => true,'class' => 'form-control bg-light'])->hint('El monto total es calculado automáticamente') ?>
        </div>
    </div>
        </div>
           
     </div>


    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Detalles de la Cotización</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="details-table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (empty($details)): ?>
        <tr class="empty-service-row">
            <td colspan="6" class="text-center">No hay servicios agregados</td>
        </tr>
    <?php else: ?>
        <?php foreach ($details as $index => $detail): ?>
            <tr>
                <td>
                    <?= Html::dropDownList(
                        "QuotationDetails[$index][service_id]",
                        $detail->service_id,
                        ArrayHelper::map(Services::find()->all(), 'id', 'name'),
                        ['class' => 'form-control service-select', 'prompt' => 'Seleccione un servicio', 'data-index' => $index]
                    ) ?>
                </td>
                <td>
                    <?= Html::textarea(
                        "QuotationDetails[$index][description]",
                        $detail->description,
                        ['class' => 'form-control description-input', 'rows' => 2, 'id' => "description-$index"]
                    ) ?>
                </td>
                <td>
                    <?= Html::textInput(
                        "QuotationDetails[$index][quantity]",
                        $detail->quantity,
                        ['class' => 'form-control quantity-input', 'type' => 'number', 'min' => 1]
                    ) ?>
                </td>
                <td>
                    <?= Html::textInput(
                        "QuotationDetails[$index][unit_price]",
                        $detail->unit_price,
                        ['class' => 'form-control price-input', 'type' => 'number', 'step' => '0.01', 'min' => 0]
                    ) ?>
                </td>
                <td>
                    <span class="subtotal" id="subtotal-<?= $index ?>">
                        <?= Yii::$app->formatter->asCurrency($detail->subtotal) ?>
                    </span>
                </td>
                <td>
                    <?= Html::button('<i class="fas fa-trash"></i>', [
                        'class' => 'btn btn-danger btn-sm delete-row',
                        'data-id' => $detail->id
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
                </table>
            </div>
            <?= Html::button('<i class="fas fa-plus"></i> Agregar Detalle', [
                'class' => 'btn btn-success',
                'id' => 'add-detail'
            ]) ?>
        </div>
    </div>

     <div class="card mt-3">

      <div class="card-header">
            <h3 class="card-title">Texto personalizado</h3>
        </div>
        <div class="card-body">
                <?= 
                $form->field($model, 'custom_footer')->widget(\dosamigos\ckeditor\CKEditor::class, [
                            'options' => ['rows' => 6],
                            'preset' => 'custom',
                            'clientOptions' => [
                                'language' => 'es',
                                'height' => 200,
                                'toolbar' => [
                                    ['Bold', 'Italic', 'Underline'], // Herramientas básicas de formato
                                    ['NumberedList', 'BulletedList'], // Listas
                                    ['Link', 'Unlink'], // Enlaces
                                    ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'], // Herramientas de alineación
                                    ['RemoveFormat'], // Eliminar formato
                                ],
                                'extraPlugins' => 'justify', // Habilitar el plugin de alineación
                                'removePlugins' => 'elementspath', // Ocultar la ruta de elementos
                                'resize_enabled' => false, // Deshabilitar el redimensionamiento del editor
                            ],
                        ])->label(false)->hint('Este texto aparecerá en la parte inferior de la cotización') ?>

        </div>
        </div>

        

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJsVar('relativeSiteUrl', Yii::$app->params['relativeSiteUrl']);
$js = <<<JS
    // Función para calcular el subtotal
    function calculateSubtotal(row) {
        var quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        var price = parseFloat(row.find('.price-input').val()) || 0;
        var subtotal = quantity * price;
        row.find('.subtotal').text(subtotal.toFixed(2)); // Actualizar el texto del subtotal
        calculateTotal(); // Recalcular el total general
    }

    // Función para calcular el total general
    function calculateTotal() {
        var total = 0;
        $('#details-table tbody tr').each(function () {
            var subtotal = parseFloat($(this).find('.subtotal').text()) || 0;
            total += subtotal;
        });
        $('#quotations-total_amount').val(total.toFixed(2)); // Actualizar el campo de monto total
    }

    // Función para actualizar los servicios disponibles
    function updateServices() {
        var quotationTypeId = $('#quotations-quotation_type_id').val();

        if (quotationTypeId) {
            $.get(relativeSiteUrl + '/web/quotations/get-services', {quotation_type_id: quotationTypeId}, function(data) {
                $('.service-select').each(function() {
                    var \$select = $(this);
                    var currentValue = \$select.val();
                    \$select.empty(); // Vaciar el dropdown

                    // Agregar la opción de placeholder
                    \$select.append('<option value="" disabled selected>Elegir servicio</option>');

                    // Cargar los servicios dinámicamente
                    $.each(data, function(key, value) {
                        \$select.append(
                            $('<option></option>')
                                .attr('value', key)
                                .text(value)
                        );
                    });

                    // Restaurar el valor seleccionado previamente
                    \$select.val(currentValue);
                });
            });
        }
    }


    // Evento para agregar nueva fila
    $('#add-detail').on('click', function () {
        var quotationTypeId = $('#quotations-quotation_type_id').val();
        if (!quotationTypeId) {
            alert('Por favor, seleccione un Tipo de Cotización antes de agregar un detalle.');
            return; // Detener la ejecución si no se seleccionó un tipo de cotización
        }

        $('#details-table tbody .empty-service-row').remove();
        var index = $('#details-table tbody tr').length;
        var row = $(`
            <tr>
                <td>
                    <select name="QuotationDetails[\${index}][service_id]" class="form-control service-select" data-index="\${index}">
                        <option value="" disabled selected>Elegir servicio</option>
                    </select>
                </td>
                <td>
                    <textarea name="QuotationDetails[\${index}][description]" class="form-control description-input" rows="2" id="description-\${index}"></textarea>
                </td>
                <td>
                    <input type="number" name="QuotationDetails[\${index}][quantity]" class="form-control quantity-input" min="1" value="1">
                </td>
                <td>
                    <input type="number" name="QuotationDetails[\${index}][unit_price]" class="form-control price-input" step="0.01" min="0" value="0">
                </td>
                <td>
                    <span class="subtotal" id="subtotal-\${index}">0.00</span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
        $('#details-table tbody').append(row);
        updateServices(); // Actualizar los servicios disponibles en el nuevo dropdown
    });

    // Evento para eliminar fila
    $(document).on('click', '.delete-row', function() {
        var id = $(this).data('id');
        var \$row = $(this).closest('tr');

        if (id) {
            if (confirm('¿Está seguro de eliminar este detalle?')) {
                $.post(relativeSiteUrl + '/web/quotation-details/delete?id=' + id, function(response) {
                    if (response.success) {
                        \$row.remove(); // Elimina la fila del DOM
                        if ($('#details-table tbody').children().length === 0) {
                            $('#details-table tbody').html(`
                                <tr class="empty-service-row">
                                    <td colspan="5" class="text-center">No hay servicios agregados</td>
                                </tr>
                            `);
                        }
                        calculateTotal(); // Recalcula el total
                    } else {
                        alert(response.message || 'No se pudo eliminar el detalle.');
                    }
                }).fail(function() {
                    alert('Error al procesar la solicitud.');
                });
            }
        } else {
            \$row.remove(); // Elimina la fila del DOM
            if ($('#details-table tbody').children().length === 0) {
                $('#details-table tbody').html(`
                    <tr class="empty-service-row">
                        <td colspan="5" class="text-center">No hay servicios agregados</td>
                    </tr>
                `);
            }
            calculateTotal(); // Recalcula el total
        }
    });

    // Eventos para calcular subtotal
    $(document).on('change', '.quantity-input, .price-input', function() {
        calculateSubtotal($(this).closest('tr'));
    });

    // Eventos para calcular el subtotal al cambiar la cantidad o el precio unitario
    $(document).on('change', '.quantity-input, .price-input', function () {
        calculateSubtotal($(this).closest('tr'));
    });

    // Evento para actualizar servicios cuando cambia el tipo de cotización
    $('#quotations-quotation_type_id').on('change', function() {
        updateServices();
        $('#details-table tbody').empty(); // Vaciar la tabla
        // Verificar si la tabla está vacía y agregar la leyenda
        if ($('#details-table tbody').children().length === 0) {
            $('#details-table tbody').html(`
                <tr class="empty-service-row">
                    <td colspan="5" class="text-center">No hay servicios agregados</td>
                </tr>
            `);
        }
        calculateTotal();
    });

    // Evento para actualizar el precio unitario al seleccionar un servicio
    $(document).on('change', '.service-select', function () {
        var \$row = $(this).closest('tr');
        var serviceId = $(this).val();

        if (serviceId) {
            // Realizar una solicitud AJAX para obtener el precio del servicio
            $.get(relativeSiteUrl + '/web/quotations/get-service-price', { service_id: serviceId }, function (data) {
                if (data.success) {
                    // Actualizar el campo "Precio Unitario" con el precio obtenido
                    \$row.find('.price-input').val(data.price);
                    // Recalcular el subtotal
                    calculateSubtotal(\$row);
                } else {
                    alert('No se pudo obtener el precio del servicio.');
                }
            });
        } else {
            // Si no se selecciona un servicio, limpiar el precio unitario y el subtotal
            \$row.find('.price-input').val('');
            \$row.find('.subtotal-input').val('');
            calculateTotal();
        }
    });

    // Evento para actualizar la descripción al seleccionar un servicio
    $(document).on('change', '.service-select', function () {
        var \$row = $(this).closest('tr');
        var serviceId = $(this).val();

        if (serviceId) {
            // Realizar una solicitud AJAX para obtener la descripción del servicio
            $.get(relativeSiteUrl + '/web/quotations/get-service-description', { service_id: serviceId }, function (data) {
                if (data.success) {
                    // Actualizar el campo "Descripción" con la descripción obtenida
                    \$row.find('.description-input').val(data.description);
                } else {
                    alert('No se pudo obtener la descripción del servicio.');
                }
            });
        } else {
            // Si no se selecciona un servicio, limpiar la descripción
            \$row.find('.description-input').val('');
        }
    });

    // Inicializar servicios disponibles
    updateServices();

    $('#client-form').on('beforeSubmit', function(e) {
    e.preventDefault();

    var form = $(this);
    $.post(form.attr('action'), form.serialize())
        .done(function(response) {
            if (response.success) {
                // Agrega el nuevo cliente al dropdown
                var select = $('#quotations-client_id');
                select.append($('<option>', {
                    value: response.id,
                    text: response.name,
                    selected: true
                }));

                $('#createClientModal').modal('hide');
                form[0].reset();
            }
        })
        .fail(function() {
            alert('Ocurrió un error al guardar el cliente.');
        });

    return false;
});
JS;

$this->registerJs($js);


Modal::begin([
    'title' => 'Agregar nuevo cliente',
    'id' => 'createClientModal',
    'size' => 'modal-lg',
]);

echo $this->render('/clients/_ajax_form', [
    'model' => new \app\models\Clients(),
    'isAjax' => true, // O una bandera para ocultar botones extra
]);

Modal::end();

?>
