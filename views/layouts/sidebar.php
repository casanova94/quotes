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
                        'items' => [
                            [
                                'label' => 'Crear Cotización',
                                'icon' => 'plus',
                                'url' => ['/quotations/create'],
                            ],
                            [
                                'label' => 'Ver Cotizaciones',
                                'icon' => 'eye',
                                'url' => ['/quotations/index'],
                            ],
                        ]
                    ],
                    [
                        'label' => 'Clientes',
                        'icon' => 'user',
                        'items' => [
                            [
                                'label' => 'Crear Cliente',
                                'icon' => 'plus',
                                'url' => ['/clients/create'],
                            ],
                            [
                                'label' => 'Ver Clientes',
                                'icon' => 'eye',
                                'url' => ['/clients/index'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Configuración',
                        'icon' => 'cog',
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
                                'label' => 'Servicios',
                                'icon' => 'cogs',
                                'url' => ['/services/index'],
                            ],
                            [
                                'label' => 'Técnicos',
                                'icon' => 'user-cog',
                                'url' => ['/technicians/index'],
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