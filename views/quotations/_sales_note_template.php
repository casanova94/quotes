<?php
/* @var $template app\models\SalesNoteTemplates */
/* @var $data array */
use yii\helpers\Html;
$quotation = $data['quotation'];
$client = $data['client'];
$details = $data['details'];
$total = $data['total'];
$footer = $data['footer'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .client-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NOTA DE VENTA</h1>
        <h2>Folio: #<?= str_pad($quotation->id, 6, '0', STR_PAD_LEFT) ?></h2>
    </div>

    <div class="company-info">
        <?php if ($template->logo): ?>
            <img src="<?= Yii::getAlias('@web/' . $template->logo) ?>" style="max-width: 200px; margin-bottom: 20px;">
        <?php endif; ?>
        <?= $template->header_text ?>
        <?= $template->company_text ?>
    </div>

    <div class="client-info">
        <h3>Información del Cliente</h3>
        <p><strong>Nombre:</strong> <?= Html::encode($client->name) ?></p>
        <p><strong>Dirección:</strong> <?= Html::encode($client->address) ?></p>
        <p><strong>Teléfono:</strong> <?= Html::encode($client->phone) ?></p>
        <p><strong>Email:</strong> <?= Html::encode($client->email) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $detail): ?>
            <tr>
                <td><?= Html::encode($detail->service->name) ?></td>
                <td><?= Html::encode($detail->description) ?></td>
                <td><?= $detail->quantity ?></td>
                <td><?= Yii::$app->formatter->asCurrency($detail->unit_price) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($detail->subtotal) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <p>Total: <?= Yii::$app->formatter->asCurrency($total) ?></p>
    </div>

    <?php if ($footer): ?>
    <div class="footer">
        <?= nl2br(Html::encode($footer)) ?>
    </div>
    <?php endif; ?>

    <div class="footer">
        <?= $template->bottom_text ?>
        <?= $template->terms_and_conditions ?>
    </div>
</body>
</html> 