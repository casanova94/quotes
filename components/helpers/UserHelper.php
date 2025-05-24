<?php

namespace app\components\helpers;

use Yii;

class UserHelper
{
    public static function isAdmin()
    {
        return Yii::$app->user->can('admin');
    }
} 