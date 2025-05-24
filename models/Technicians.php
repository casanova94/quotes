<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "technicians".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 *
 * @property Quotations[] $quotations
 */
class Technicians extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technicians';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'email'], 'default', 'value' => null],
            [['name'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'phone' => 'Teléfono',
            'email' => 'Correo Electrónico',
        ];
    }

    public function getServiceOrders()
    {
        return $this->hasMany(ServiceOrder::class, ['technician_id' => 'id']);
    }

}
