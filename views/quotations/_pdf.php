<?php
/** @var app\models\Quotations $quotation */
/** @var app\models\QuotationTemplates $template */

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización #<?= $quotation->id ?></title>
    <style>
        body {
            font-family: <?= $template->font_family ?: 'Arial, sans-serif' ?>;
            background-color: <?= $template->background_color ?: '#ffffff' ?>;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .details-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <?php if ($template->logo_url): ?>
            <img src="<?= Yii::getAlias('@web') . '/' . $template->logo_url ?>" alt="Logo" height="300">
        <?php endif; ?>
        <h3><?= $template->header_text ?: 'Cotización' ?></h3>
    </div>

    <h3>Información del Cliente</h3>
    <p><strong>Nombre:</strong> <?= $quotation->client->name ?></p>
    <p><strong>Fecha:</strong> <?= Yii::$app->formatter->asDate($quotation->created_at) ?></p>

    <h3>Detalles de la Cotización</h3>
    <table class="details-table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quotation->quotationDetails as $detail): ?>
                <tr>
                    <td><?= $detail->service->name ?></td>
                    <td><?= $detail->quantity ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($detail->unit_price) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($detail->subtotal) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: <?= Yii::$app->formatter->asCurrency($quotation->total_amount) ?></h3>

    <div class="footer">
        <?= $template->footer_text ?: 'Gracias por su preferencia.' ?>
        <?= $template->terms_and_conditions ?>
    </div>
</body>
</html>