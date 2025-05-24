<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReports $model */
/** @var app\models\SiteInspectionObservations[] $observations */
/** @var app\models\Technicians[] $technicians */

$this->title = 'Actualizar reporte de inspección: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reportes de Inspección', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="site-inspection-reports-update">


    <?= $this->render('_form', [
        'model' => $model,
        'observations' => $observations,
        'technicians' => $technicians,
    ]) ?>

</div>
