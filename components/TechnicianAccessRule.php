<?php

namespace app\components;

use Yii;
use yii\rbac\Rule;

class TechnicianAccessRule extends Rule
{
    public $name = 'isTechnicianOwner';

    public function execute($user, $item, $params)
    {
        if (!isset($params['model'])) {
            return false;
        }

        $model = $params['model'];
        
        // Si el usuario es admin, permitir todo
        if (Yii::$app->authManager->checkAccess($user, 'admin')) {
            return true;
        }

        // Verificar si el usuario es técnico
        if (!Yii::$app->authManager->checkAccess($user, 'technician')) {
            return false;
        }

        // Obtener el ID del técnico asociado al usuario
        $technician = Yii::$app->user->identity->technician;
        if (!$technician) {
            return false;
        }

        // Verificar si el modelo tiene un campo technician_id
        if (isset($model->technician_id)) {
            return $model->technician_id == $technician->id;
        }

        return false;
    }
} 