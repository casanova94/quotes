<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\QuotationTemplates $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Quotation Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quotation-templates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'quotation_type_id',
            'header_text:ntext',
            'footer_text:ntext',
            'logo_url:url',
            'background_color',
            'font_family',
            'default_comments:ntext',
            'terms_and_conditions:ntext',
            'show_prices',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
