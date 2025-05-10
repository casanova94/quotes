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
            font-family:
                <?= $template->font_family ?: 'Arial, sans-serif' ?>
            ;
            background-color:
                <?= $template->background_color ?: '#ffffff' ?>
            ;
            margin: 0;
            padding: 0;
        }

        .header {
            margin-bottom: 40px;
        }

        .footer {
            margin-top: 100px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .details-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .client-info {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .client-info h3 {
            margin-top: 0;
        }

        .client-info p {
            margin: 5px 0;
        }
    </style>
</head>

<body>

<div style="width: 100%; overflow: hidden;">
    <div style="width: 50%; float: left;text-align: center;">
        <?php if ($template->logo_url): ?>
            <img src="<?= Yii::getAlias('@webroot') . '/' . $template->logo_url ?>" alt="Logo" style="height: 200px;">
        <?php endif; ?>
    </div>
    <div style="width: 50%; float: right; text-align: right;">
        <?= $template->header_text ?: '<h3 style="margin: 0;">Cotización</h3>' ?>
    </div>
</div>


    <div class="client-info" style="display: none;">
        <h3>Información del Cliente</h3>
        <p><strong>Nombre:</strong> <?= $quotation->client->name ?></p>
        <p><strong>Teléfono:</strong> <?= $quotation->client->phone ?: 'No disponible' ?></p>
        <!--        <p><strong>Dirección:</strong> <?= $quotation->client->address ?: 'No disponible' ?></p>-->
        <p><strong>Fecha:</strong> <?= Yii::$app->formatter->asDate($quotation->created_at) ?></p>
    </div>
  
    <h3>Detalles de la Cotización</h3>
    <table class="details-table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Unidad</th> <!-- Nueva columna para la unidad -->
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quotation->quotationDetails as $detail): ?>
                <tr>
                    <td><?= $detail->service->name ?></td>
                    <td><?= $detail->service->unit ?></td> <!-- Mostrar la unidad del servicio -->
                    <td><?= $detail->quantity ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($detail->unit_price) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($detail->subtotal) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: <?= Yii::$app->formatter->asCurrency($quotation->total_amount) ?></h3>

    <div class="footer">
        <!-- Renderizar el HTML del footer_text -->
        <div><?= $template->footer_text ?: 'Gracias por su preferencia.' ?></div>
    </div>
</body>

</html>