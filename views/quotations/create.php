<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quotations $model */

$this->title = 'Create Quotations';
$this->params['breadcrumbs'][] = ['label' => 'Quotations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
