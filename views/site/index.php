<?php
date_default_timezone_set('America/Mexico_City');

use app\models\Clients;
use app\models\Quotations;
use app\models\QuotationStatuses;

$this->title = 'Panel de control';
$this->params['breadcrumbs'] = [['label' => $this->title]];

// Consultas para obtener los datos
$totalClients = Clients::find()->count();
$totalQuotations = Quotations::find()->count();

// Obtener el rango de fechas para hoy
$startOfDay = (new \DateTime('today'))->format('Y-m-d H:i:s');
$endOfDay = (new \DateTime('tomorrow'))->modify('-1 second')->format('Y-m-d H:i:s');

// Consultas para registros creados hoy
$clientsToday = Clients::find()
    ->where(['between', 'created_at', $startOfDay, $endOfDay])
    ->count();

$quotationsToday = Quotations::find()
    ->where(['between', 'created_at', $startOfDay, $endOfDay])
    ->count();

// Consultar los estados de las cotizaciones
$statuses = QuotationStatuses::find()->all();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Total de clientes y cotizaciones</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Total de clientes -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <?= \hail812\adminlte\widgets\SmallBox::widget([
                                'title' => $totalClients,
                                'text' => 'Clientes registrados',
                                'icon' => 'fas fa-user',
                                'linkUrl' => Yii::$app->urlManager->createUrl(['clients/index']),
                                'theme' => 'primary',
                                'linkText' => 'Ver clientes',
                            ]) ?>
                        </div>

                        <!-- Total de cotizaciones -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <?= \hail812\adminlte\widgets\SmallBox::widget([
                                'title' => $totalQuotations,
                                'text' => 'Cotizaciones registradas',
                                'icon' => 'fas fa-file-alt',
                                'linkUrl' => Yii::$app->urlManager->createUrl(['quotations/index']),
                                'theme' => 'info',
                                'linkText' => 'Ver cotizaciones',
                            ]) ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen del día</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Clientes creados hoy -->
                        <div class="col-md-6 col-12">
                            <?= \hail812\adminlte\widgets\SmallBox::widget([
                                'title' => $clientsToday,
                                'text' => 'Clientes creados hoy',
                                'icon' => 'fas fa-user-plus',
                                'theme' => 'success',
                                'linkText' => '&nbsp;', 
                                'linkUrl' => '#',
                                'linkOptions' => [
                                    'class' => 'small-box-footer',
                                    'style' => 'color: transparent !important;' 
                                ]
                            ]) ?>
                        </div>

                        <!-- Cotizaciones creadas hoy -->
                        <div class="col-md-6 col-12">
                            <?= \hail812\adminlte\widgets\SmallBox::widget([
                                'title' => $quotationsToday,
                                'text' => 'Cotizaciones creadas hoy',
                                'icon' => 'fas fa-file-invoice',
                                'theme' => 'warning',
                                 'linkText' => '&nbsp;', 
                                'linkUrl' => '#',
                                'linkOptions' => [
                                    'class' => 'small-box-footer',
                                    'style' => 'color: transparent !important;' 
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen de cotizaciones por estado</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($statuses as $status): ?>
                            <?php
                            // Obtener el número de cotizaciones para el estado actual
                            $count = Quotations::find()->where(['status_id' => $status->id])->count();

                            // Usar el color definido en color_code o un color predeterminado
                            $color = $status->color_code ?: 'secondary'; // Si no hay color definido, usar 'secondary'
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <!-- Usar el color del estado en el encabezado -->
                                    <div class="card-header" style="background-color: <?= $color ?>; color: #fff;">
                                        <h5 class="card-title"><i class="fas fa-info-circle"></i>
                                            <?= htmlspecialchars($status->name) ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="display-4 text-center"><?= $count ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>