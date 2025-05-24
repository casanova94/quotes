<?php
date_default_timezone_set('America/Merida'); // Establecer la zona horaria a Mérida, México

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\ServiceOrder;
use app\models\Technicians;

/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReports $model */
/** @var app\models\SiteInspectionObservations[] $observations */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="site-inspection-reports-form">

    <?php $form = ActiveForm::begin(['id' => 'site-inspection-report-form']); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos Generales</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'service_order_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(ServiceOrder::find()->all(), 'id', 'id'),
                        'options' => [
                            'placeholder' => 'Seleccione una orden de servicio...',
                            'value' => Yii::$app->request->get('service_order_id'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'technician_id')->widget(Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map($technicians, 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Seleccione un técnico...',
                            'value' => Yii::$app->user->identity->isTechnician() ? Yii::$app->user->identity->technician->id : null,
                        ],
                        'pluginOptions' => [
                            'allowClear' => !Yii::$app->user->identity->isTechnician()
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'inspection_date')->input('date', [
                        'value' => $model->inspection_date ?: date('Y-m-d'),
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'device_condition_notes')->textarea(['rows' => 4]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Observaciones</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="observations-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($observations)): ?>
                            <tr class="empty-observation-row">
                                <td colspan="3" class="text-center">No hay observaciones agregadas</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($observations as $index => $observation): ?>
                                <tr>
                                    <td>
                                        <?= Html::hiddenInput("SiteInspectionObservations[$index][id]", $observation->id) ?>
                                        <?= Html::textInput("SiteInspectionObservations[$index][title]", $observation->title, ['class' => 'form-control']) ?>
                                    </td>
                                    <td>
                                        <?= Html::textarea("SiteInspectionObservations[$index][description]", $observation->description, ['class' => 'form-control', 'rows' => 2]) ?>
                                    </td>
                                    <td>
                                        <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-danger btn-sm delete-row']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?= Html::button('<i class="fas fa-plus"></i> Agregar Observación', ['class' => 'btn btn-success', 'id' => 'add-observation']) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
    // Evento para agregar una nueva fila de observación
    $('#add-observation').on('click', function () {
        $('#observations-table tbody .empty-observation-row').remove();
        var index = $('#observations-table tbody tr').length;
        var row = `
            <tr>
                <td>
                    <input type="text" name="SiteInspectionObservations[\${index}][title]" class="form-control">
                </td>
                <td>
                    <textarea name="SiteInspectionObservations[\${index}][description]" class="form-control" rows="2"></textarea>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#observations-table tbody').append(row);
    });

    // Evento para eliminar una fila de observación
    $(document).on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
        if ($('#observations-table tbody tr').length === 0) {
            $('#observations-table tbody').html(`
                <tr class="empty-observation-row">
                    <td colspan="3" class="text-center">No hay observaciones agregadas</td>
                </tr>
            `);
        }
    });
JS;

$this->registerJs($js);
?>
