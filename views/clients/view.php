<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\helpers\UserHelper;

/** @var yii\web\View $this */
/** @var app\models\Clients $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clients-view">

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (UserHelper::isAdmin()): ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Desea eliminar este cliente?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'email:email',
            [
                'attribute' => 'phone',
                'format' => 'raw', // Permitir HTML en el valor
                'value' => function ($model) {
                    return Html::a(
                        $model->phone,
                        'tel:' . $model->phone,
                        ['class' => 'btn btn-link px-0 mx-0']
                    );
                },
            ],
            'address:ntext',
            'created_at',
        ],
    ]) ?>

    <h3>Cotizaciones del Cliente</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Cotizaciones',
                'format' => 'raw',
                'value' => function ($model) {
                    $output = '';
                    foreach ($model->quotations as $quotation) {
                        $output .= Html::a(
                            'Cotización #' . str_pad($quotation->id, 6, '0', STR_PAD_LEFT),
                            ['quotations/view', 'id' => $quotation->id],
                            ['class' => 'btn btn-link']
                        ) . '<br>';
                    }
                    return $output ?: 'No hay cotizaciones asociadas.';
                },
            ],
        ],
    ]) ?>

</div>
