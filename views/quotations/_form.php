<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Clients;
use app\models\QuotationTypes;
use app\models\Technicians;
use app\models\QuotationStatuses;
use app\models\Services;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */
/** @var app\models\QuotationDetails[] $details */
?>

<div class="quotations-form">
    <?php $form = ActiveForm::begin(['id' => 'quotation-form']); ?>

     <div class="card mt-3">

      <div class="card-header">
            <h3 class="card-title">Datos Generales</h3>
        </div>
        <div class="card-body">
             <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'client_id')->dropDownList(
                ArrayHelper::map(Clients::find()->all(), 'id', 'name'),
                ['prompt' => 'Seleccione un cliente']
            ) ?>
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
            <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true, 'readonly' => true]) ?>
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
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $details = $details ?? [];
                        foreach ($details as $index => $detail): 
                        ?>
                            <tr>
                                <td>
                                    <?= Html::dropDownList(
                                        "QuotationDetails[$index][service_id]",
                                        $detail->service_id,
                                        ArrayHelper::map(Services::find()->where(['quotation_type_id' => $model->quotation_type_id])->all(), 'id', 'name'),
                                        ['class' => 'form-control service-select']
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
                                    <?= Html::textInput(
                                        "QuotationDetails[$index][subtotal]",
                                        $detail->subtotal,
                                        ['class' => 'form-control subtotal-input', 'readonly' => true]
                                    ) ?>
                                </td>
                                <td>
                                    <?= Html::button('<i class="fas fa-trash"></i>', [
                                        'class' => 'btn btn-danger btn-sm delete-row',
                                        'data-id' => $detail->id
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?= Html::button('<i class="fas fa-plus"></i> Agregar Detalle', [
                'class' => 'btn btn-success',
                'id' => 'add-detail'
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'custom_footer')->textarea(['rows' => 6]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
    // Función para calcular el subtotal
    function calculateSubtotal(row) {
        var quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        var price = parseFloat(row.find('.price-input').val()) || 0;
        var subtotal = quantity * price;
        row.find('.subtotal-input').val(subtotal.toFixed(2));
        calculateTotal();
    }

    // Función para calcular el total
    function calculateTotal() {
        var total = 0;
        $('.subtotal-input').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#quotations-total_amount').val(total.toFixed(2));
    }

    // Función para actualizar los servicios disponibles
    function updateServices() {
    var quotationTypeId = \$('#quotations-quotation_type_id').val();

    if (quotationTypeId) {
        \$.get('/quotes/web/quotations/get-services', {quotation_type_id: quotationTypeId}, function(data) {
            \$('.service-select').each(function() {
                var \$select = \$(this);
                var currentValue = \$select.val();
                \$select.empty();

                \$.each(data, function(key, value) {
                    \$select.append(
                        \$('<option></option>')
                            .attr('value', key)
                            .text(value)
                    );
                });

                \$select.val(currentValue);
            });
        });
    }
}


    // Evento para agregar nueva fila
    $('#add-detail').on('click', function() {
        var index = $('#details-table tbody tr').length;
        var row = $('<tr>');
        row.html(`
            <td>
                <select name="QuotationDetails[\\\${index}][service_id]" class="form-control service-select">
                    <option value="">Seleccione un servicio</option>
                </select>
            </td>
            <td>
                <input type="number" name="QuotationDetails[\\\${index}][quantity]" class="form-control quantity-input" min="1" value="1">
            </td>
            <td>
                <input type="number" name="QuotationDetails[\\\${index}][unit_price]" class="form-control price-input" step="0.01" min="0" value="0">
            </td>
            <td>
                <input type="text" name="QuotationDetails[\\\${index}][subtotal]" class="form-control subtotal-input" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `);
        $('#details-table tbody').append(row);
        updateServices();
    });

    // Evento para eliminar fila
    $(document).on('click', '.delete-row', function() {
        var id = $(this).data('id');
        if (id) {
            if (confirm('¿Está seguro de eliminar este detalle?')) {
                $.post('/quotation-details/delete', {id: id}, function(response) {
                    if (response.success) {
                        $(this).closest('tr').remove();
                        calculateTotal();
                    }
                });
            }
        } else {
            $(this).closest('tr').remove();
            calculateTotal();
        }
    });

    // Eventos para calcular subtotal
    $(document).on('change', '.quantity-input, .price-input', function() {
        calculateSubtotal($(this).closest('tr'));
    });

    // Evento para actualizar servicios cuando cambia el tipo de cotización
    $('#quotations-quotation_type_id').on('change', function() {
        updateServices();
        $('#details-table tbody').empty();
        calculateTotal();
    });

    // Inicializar servicios disponibles
    updateServices();
JS;

$this->registerJs($js);
?>
