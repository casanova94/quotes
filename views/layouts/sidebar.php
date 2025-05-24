<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Yii::getAlias('@web')?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/img/poe-logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->params['companyName']?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Inicio',
                        'icon' => 'home',
                        'url' => ['/site/index'],
                    ],
                    [
                        'label' => 'Cotizaciones',
                        'icon' => 'file',
                        'url' => ['/quotations/index'],
                        'visible' => !Yii::$app->user->identity->isTechnician(),
                    ],
                    [
                        'label' => 'Órdenes de Servicio',
                        'icon' => 'clipboard',
                        'url' => ['/service-orders/index']
                    ],
                    [
                        'label' => 'Clientes',
                        'icon' => 'user',
                        'url' => ['/clients/index'],
                        'visible' => !Yii::$app->user->identity->isTechnician(),
                    ],
                    [
                        'label' => 'Técnicos',
                        'icon' => 'user-cog',
                        'url' => ['/technicians/index'],
                        'visible' => !Yii::$app->user->identity->isTechnician(),
                    ],
                    [
                        'label' => 'Reportes de Inspección',
                        'icon' => 'clipboard',
                        'url' => ['/site-inspection-reports/index']
                    ],
                    [
                        'label' => 'Configuración',
                        'icon' => 'cog',
                        'visible' => !Yii::$app->user->identity->isTechnician(),
                        'items' => [
                            [
                                'label' => 'Tipos de Cotización',
                                'icon' => 'file-alt',
                                'url' => ['/quotation-types/index'],
                            ],
                            [
                                'label' => 'Estados de Cotización',
                                'icon' => 'check-circle',
                                'url' => ['/quotation-statuses/index'],
                            ],
                            [
                                'label' => 'Plantillas de Cotización',
                                'icon' => 'file-code',
                                'url' => ['/quotation-templates/index'],
                            ],
                            [
                                'label' => 'Plantillas de Notas de Venta',
                                'icon' => 'file-invoice',
                                'url' => ['/sales-note-templates/index'],
                            ],
                            [
                                'label' => 'Servicios',
                                'icon' => 'cogs',
                                'url' => ['/services/index'],
                            ],
                            [
                                'label' => 'Usuarios',
                                'icon' => 'users',
                                'url' => ['/users/index'],
                                'visible' => Yii::$app->user->can('admin'),
                            ],
                        ],
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<style>
    @media (max-width: 768px) {
        .main-sidebar .nav-sidebar .nav-link {
            font-size: 20px; /* Aumenta el tamaño de la fuente */
        }
    }
</style>