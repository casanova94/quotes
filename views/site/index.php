<?php
date_default_timezone_set('America/Mexico_City');

use app\models\Clients;
use app\models\Quotations;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\ServiceOrder;
use app\components\helpers\UserHelper;

$this->title = 'Panel de control';
$this->params['breadcrumbs'] = [['label' => $this->title]];

// Consultas para obtener los datos
$totalClients = Clients::find()->count();
$totalQuotations = Quotations::find()->count();
$totalServiceOrders = ServiceOrder::find()->count();

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

// Obtener órdenes de servicio por estado
$pendingOrders = ServiceOrder::find()->where(['status' => ServiceOrder::STATUS_PENDING])->count();
$inProgressOrders = ServiceOrder::find()->where(['status' => ServiceOrder::STATUS_IN_PROGRESS])->count();
$completedOrders = ServiceOrder::find()->where(['status' => ServiceOrder::STATUS_COMPLETED])->count();
$cancelledOrders = ServiceOrder::find()->where(['status' => ServiceOrder::STATUS_CANCELLED])->count();

// Obtener órdenes de servicio recientes
$recentOrders = ServiceOrder::find()
    ->orderBy(['scheduledDateTime' => SORT_DESC])
    ->limit(5)
    ->all();
?>

<div class="container-fluid">
    <div class="row">
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

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Estado de Órdenes de Servicio
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $pendingOrders ?></h3>
                                    <p>Pendientes</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $inProgressOrders ?></h3>
                                    <p>En Proceso</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $completedOrders ?></h3>
                                    <p>Completadas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Totales
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $totalQuotations ?></h3>
                                    <p>Cotizaciones</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <?= Html::a('Ver todas', ['/quotations/index'], ['class' => 'small-box-footer']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $totalClients ?></h3>
                                    <p>Clientes</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <?= Html::a('Ver todos', ['/clients/index'], ['class' => 'small-box-footer']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $totalServiceOrders ?></h3>
                                    <p>Órdenes de Servicio</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <?= Html::a('Ver todas', ['/service-orders/index'], ['class' => 'small-box-footer']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Órdenes de Servicio Recientes
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (empty($recentOrders)): ?>
                        <p class="text-center">No hay órdenes de servicio recientes.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Fecha Programada</th>
                                        <?php if (!UserHelper::isTechnician()): ?>
                                            <th>Cotización</th>
                                        <?php endif; ?>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td><?= str_pad($order->id, 6, '0', STR_PAD_LEFT) ?></td>
                                            <td><?= $order->quotation->client->name ?></td>
                                            <td>
                                                <span class="badge badge-<?= $order->status == ServiceOrder::STATUS_PENDING ? 'warning' : 
                                                    ($order->status == ServiceOrder::STATUS_IN_PROGRESS ? 'info' : 
                                                    ($order->status == ServiceOrder::STATUS_COMPLETED ? 'success' : 
                                                    ($order->status == ServiceOrder::STATUS_CANCELLED ? 'danger' : 'secondary'))) ?>">
                                                    <?= $order->status ?>
                                                </span>
                                            </td>
                                            <td><?= Yii::$app->formatter->asDatetime($order->scheduledDateTime) ?></td>
                                            <?php if (!UserHelper::isTechnician()): ?>
                                                <td>
                                                    <?= Html::a(
                                                        str_pad($order->quotation->id, 6, '0', STR_PAD_LEFT),
                                                        ['/quotations/view', 'id' => $order->quotation->id],
                                                        ['title' => 'Ver cotización']
                                                    ) ?>
                                                </td>
                                            <?php endif; ?>
                                            <td>
                                                <?= Html::a(
                                                    '<i class="fas fa-eye"></i>',
                                                    ['/service-orders/view', 'id' => $order->id],
                                                    [
                                                        'class' => 'btn btn-primary btn-sm',
                                                        'title' => 'Ver detalles',
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>