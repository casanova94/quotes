<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationStatuses $model */

$this->title = 'Create Quotation Statuses';
$this->params['breadcrumbs'][] = ['label' => 'Quotation Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-statuses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
