<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\ServiceOrder;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard del Técnico';
$this->params['breadcrumbs'][] = $this->title;

// Obtener las órdenes de servicio asignadas al técnico actual
$technician = Yii::$app->user->identity->technician;
$serviceOrders = ServiceOrder::find()
    ->where(['technician_id' => $technician->id])
    ->orderBy(['scheduledDateTime' => SORT_ASC])
    ->all();
?>

<div class="site-technician-dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks"></i> Mis Órdenes de Servicio
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cotización</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th>Fecha Programada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($serviceOrders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay órdenes de servicio asignadas.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($serviceOrders as $index => $order): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <?= Html::a(
                                                    str_pad($order->quotation->id, 6, '0', STR_PAD_LEFT) . ' - ' . $order->quotation->name,
                                                    ['/quotations/view', 'id' => $order->quotation->id],
                                                    ['class' => 'btn btn-link']
                                                ) ?>
                                            </td>
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
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Resumen de Órdenes
                    </h3>
                </div>
                <div class="card-body">
                    <?php
                    $pendingCount = 0;
                    $inProgressCount = 0;
                    $completedCount = 0;
                    $cancelledCount = 0;
                    
                    foreach ($serviceOrders as $order) {
                        switch ($order->status) {
                            case ServiceOrder::STATUS_PENDING:
                                $pendingCount++;
                                break;
                            case ServiceOrder::STATUS_IN_PROGRESS:
                                $inProgressCount++;
                                break;
                            case ServiceOrder::STATUS_COMPLETED:
                                $completedCount++;
                                break;
                            case ServiceOrder::STATUS_CANCELLED:
                                $cancelledCount++;
                                break;
                        }
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $pendingCount ?></h3>
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
                                    <h3><?= $inProgressCount ?></h3>
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
                                    <h3><?= $completedCount ?></h3>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar"></i> Próximas Visitas
                    </h3>
                </div>
                <div class="card-body">
                    <?php
                    $upcomingOrders = array_filter($serviceOrders, function($order) {
                        return $order->status != ServiceOrder::STATUS_COMPLETED && 
                               strtotime($order->scheduledDateTime) >= strtotime('today');
                    });
                    
                    if (empty($upcomingOrders)): ?>
                        <p class="text-center">No hay visitas programadas.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($upcomingOrders as $order): ?>
                                        <tr>
                                            <td><?= Yii::$app->formatter->asDatetime($order->scheduledDateTime) ?></td>
                                            <td><?= $order->quotation->client->name ?></td>
                                            <td>
                                                <span class="badge badge-<?= $order->status == ServiceOrder::STATUS_PENDING ? 'warning' : 
                                                    ($order->status == ServiceOrder::STATUS_IN_PROGRESS ? 'info' : 
                                                    ($order->status == ServiceOrder::STATUS_CANCELLED ? 'danger' : 'secondary')) ?>">
                                                    <?= $order->status ?>
                                                </span>
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