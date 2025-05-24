<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use app\models\Quotations;
use app\models\Technicians;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\ServiceOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-order-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card mt-3">
    
    <div class="card-body">
    <?= $form->field($model, 'quotation_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(
            Quotations::find()
                ->where(['status' => 'Aceptada'])
                ->all(),
            'id',
            function($model) {
                return 'Cotización #' . str_pad($model->id, 6, '0', STR_PAD_LEFT) . ' - ' . $model->name . ' - ' . $model->client->name;
            }
        ),
        'options' => ['placeholder' => 'Seleccione una cotización...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        'Pendiente' => 'Pendiente',
        'En proceso' => 'En proceso',
        'Finalizado' => 'Finalizado',
        'Cancelado' => 'Cancelado',
    ]) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'scheduledDateTime')->widget(DateTimePicker::class, [
        'options' => ['placeholder' => 'Seleccione fecha y hora...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
    ]) ?>

    <?= $form->field($model, 'technician_id')->widget(Select2::class, [
        'data' =>  ArrayHelper::map(Technicians::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Seleccione un técnico...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div> 