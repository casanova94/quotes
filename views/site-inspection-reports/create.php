<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SiteInspectionReports $model */
/** @var app\models\SiteInspectionObservations[] $observations */
 

$this->title = 'Crear reporte de inspección';
$this->params['breadcrumbs'][] = ['label' => 'Reportes de Inspección', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear';
?>


<div class="site-inspection-reports-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
