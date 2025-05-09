<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\QuotationDetails $model */

$this->title = 'Create Quotation Details';
$this->params['breadcrumbs'][] = ['label' => 'Quotation Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
