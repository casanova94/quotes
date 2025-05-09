<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $created_at
 *
 * @property Quotations[] $quotations
 */
class Clients extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'phone', 'address'], 'default', 'value' => null],
            [['name'], 'required'],
            [['address'], 'string'],
            [['created_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
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
            'email' => 'Correo Electrónico',
            'phone' => 'Teléfono',
            'address' => 'Dirección',
            'created_at' => 'Fecha de Creación',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * Gets query for [[Quotations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotations::class, ['client_id' => 'id']);
    }

}
