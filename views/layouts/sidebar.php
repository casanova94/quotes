<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Yii::getAlias('@web')?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/img/poe-logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->params['companyName']?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                   
                    [
                        'label' => 'Clientes',
                        'icon' => 'user',   
                        'url' => ['/clients/index']
                    ],
                       [
                        'label' => 'Cotizaciones',
                        'icon' => 'file',   
                        'url' => ['/quotations/index']
                    ],
                    [
                        'label' => 'Configuración',
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
                        'icon' => 'cog',
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>