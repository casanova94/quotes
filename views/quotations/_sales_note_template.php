<?php
/* @var $template app\models\SalesNoteTemplates */
/* @var $data array */
use yii\helpers\Html;
$quotation = $data['quotation'];
$client = $data['client'];
$details = $data['details'];
$total = $data['total'];
$footer = $data['footer'];
date_default_timezone_set('America/Merida');
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #1773c8;
            color: white;
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
    <div>
        <h1 style="background-color:#f2f2f2; margin-bottom: 10px;text-align: center;">NOTA DE VENTA</h1>
        <div style="width: 100%; overflow: hidden;">
            <div style="width: 50%; float: right;padding-top:30px;">
                <?= $template->header_text ?>
            </div>
            <?php if ($template->logo): ?>
                <div style="float: left; text-align: center;width: 50%;">
                    <img src="<?= Yii::getAlias('@web/' . $template->logo) ?>" style="max-width: 200px; height: auto;margin-top: auto;margin-bottom: auto;">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <table>
        <tr>
            <th>Cliente</th>
            <td><?= Html::encode($client->name) ?></td>
            <th>Folio</th>
            <td>#<?= str_pad($quotation->id, 6, '0', STR_PAD_LEFT) ?></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><?= Html::encode($client->phone) ?></td>
            <th>Fecha</th>
            <td><?= Yii::$app->formatter->asDate(date('Y-m-d')) ?></td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?= Html::encode($client->address) ?></td>
            <th>Ciudad</th>
            <td>Mérida, Yucatán</td>
        </tr>
    </table>

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
            <?php 
            $total = 0;
            foreach ($details as $detail): 
                $subtotal = $detail->quantity * $detail->unit_price;
                $total += $subtotal;
            ?>
            <tr>
                <td><?= Html::encode($detail->service->name) ?></td>
                <td><?= Html::encode($detail->description) ?></td>
                <td><?= $detail->quantity ?></td>
                <td><?= Yii::$app->formatter->asCurrency($detail->unit_price) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($subtotal) ?></td>
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


</body>
</html> 