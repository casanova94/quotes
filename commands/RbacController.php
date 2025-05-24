<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\TechnicianAccessRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Crear regla personalizada
        $rule = new TechnicianAccessRule();
        $auth->add($rule);

        // Crear roles
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrador del sistema';
        $auth->add($admin);

        $technician = $auth->createRole('technician');
        $technician->description = 'Técnico del sistema';
        $auth->add($technician);

        // Crear permisos para órdenes de servicio
        $viewServiceOrder = $auth->createPermission('viewServiceOrder');
        $viewServiceOrder->description = 'Ver órdenes de servicio';
        $auth->add($viewServiceOrder);

        $manageServiceOrder = $auth->createPermission('manageServiceOrder');
        $manageServiceOrder->description = 'Gestionar órdenes de servicio';
        $auth->add($manageServiceOrder);

        // Crear permisos para reportes de inspección
        $viewInspectionReport = $auth->createPermission('viewInspectionReport');
        $viewInspectionReport->description = 'Ver reportes de inspección';
        $auth->add($viewInspectionReport);

        $manageInspectionReport = $auth->createPermission('manageInspectionReport');
        $manageInspectionReport->description = 'Gestionar reportes de inspección';
        $auth->add($manageInspectionReport);

        // Asignar permisos a roles
        $auth->addChild($technician, $viewServiceOrder);
        $auth->addChild($technician, $manageServiceOrder);
        $auth->addChild($technician, $viewInspectionReport);
        $auth->addChild($technician, $manageInspectionReport);

        // El admin hereda todos los permisos del técnico
        $auth->addChild($admin, $technician);

        echo "RBAC inicializado correctamente.\n";
    }
} 