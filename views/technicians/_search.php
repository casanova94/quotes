<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TechniciansSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="technicians-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'user.username')->label('Usuario') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'user.status')->dropDownList([
                '' => 'Todos',
                '10' => 'Activo',
                '9' => 'Inactivo',
            ])->label('Estado') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
