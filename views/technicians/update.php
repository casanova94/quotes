<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\helpers\UserHelper;

/** @var yii\web\View $this */
/** @var app\models\Technicians $model */

$this->title = 'Actualizar Técnico: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Técnicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="technicians-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => true]) ?>

            <?php if (UserHelper::isAdmin()): ?>
                <?= Html::a('Resetear Contraseña', ['reset-password', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?php endif; ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Cancelar', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
