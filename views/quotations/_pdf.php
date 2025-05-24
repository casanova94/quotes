<?php
/** @var app\models\Quotations $quotation */
/** @var app\models\QuotationTemplates $template */
use yii\helpers\Html;
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

        .custom-footer {
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 10px;
        }

        .footer {
            margin-top: 30px;
            padding: 10px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
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
    <div style="width: 50%; float: right;">
        <?= $template->header_text ?: '<h3 style="margin: 0;">Cotización</h3>' ?>
    </div>
</div>

<div style="margin-top: 20px;margin-bottom: 20px;">
      <div style="width: 50%; float: left;text-align: left;">
       <?php if ($quotation->name): ?>
            <h4 style="margin-top: 0;padding-top: 0;"><?= Html::encode($quotation->name) ?></h4>
       <?php endif; ?>
       Estimado(a) <?= $quotation->client->name ?>,
    </div>
    <div style="width: 50%; float: right; text-align: right;">
            Fecha: <?= Yii::$app->formatter->asDate($quotation->created_at) ?>  
    </div>
</div>
<?php if ($template->overview_text): ?>
    <div>
        <?= $template->overview_text ?>
    </div>
<?php endif; ?>

  

    <table class="details-table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Descripción</th> <!-- Nueva columna para la descripción -->
                <th>Unidad</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quotation->quotationDetails as $detail): ?>
                <tr>
                    <td><?= $detail->service->name ?></td>
                    <td><?= $detail->description ?: 'Sin descripción' ?></td> <!-- Mostrar descripción personalizada -->
                    <td><?= $detail->service->unit ?></td>
                    <td><?= $detail->quantity ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($detail->unit_price) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($detail->subtotal) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4"></td>
                <td><strong>Total:</strong></td>
                <td><strong><?php
                    if (empty($quotation->total_amount) || $quotation->total_amount == 0) {
                        $total = 0;
                        foreach ($quotation->quotationDetails as $detail) {
                            $total += $detail->quantity * $detail->unit_price;
                        }
                        echo Yii::$app->formatter->asCurrency($total);
                    } else {
                        echo Yii::$app->formatter->asCurrency($quotation->total_amount);
                    }
                ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div style="clear: both;"></div>

    <?php if ($quotation->custom_footer): ?>
        <div class="custom-footer">
            <?= $quotation->custom_footer ?>
        </div>
    <?php endif; ?>

    <div class="footer">
        <div class="footer-text">
            <?= $template->footer_text ?: 'Gracias por su preferencia.' ?>
        </div>
    </div>
</body>

</html>