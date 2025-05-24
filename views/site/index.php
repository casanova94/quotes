<?php
date_default_timezone_set('America/Mexico_City');

use app\models\Clients;
use app\models\Quotations;

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
                                'linkUrl' => 'javascript:void(0);',
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
                                'linkUrl' => 'javascript:void(0);',
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
    </div>
</div>