<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotation_details".
 *
 * @property int $id
 * @property int $quotation_id
 * @property int $service_id
 * @property int $quantity
 * @property float $unit_price
 * @property float|null $subtotal
 *
 * @property Quotations $quotation
 * @property Services $service
 */
class QuotationDetails extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotation_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subtotal'], 'default', 'value' => null],
            [['quotation_id', 'service_id', 'quantity', 'unit_price'], 'required'],
            [['quotation_id', 'service_id', 'quantity'], 'integer'],
            [['unit_price', 'subtotal'], 'number'],
            [['description'], 'string'], // Nueva regla para el campo description
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotations::class, 'targetAttribute' => ['quotation_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Cotización',
            'service_id' => 'Servicio',
            'quantity' => 'Cantidad',
            'unit_price' => 'Precio Unitario',
            'subtotal' => 'Subtotal',
            'quotationName' => 'Cotización',
            'serviceName' => 'Servicio',
            'description' => 'Descripción', // Etiqueta para el nuevo campo
        ];
    }

    /**
     * Gets query for [[Quotation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotation()
    {
        return $this->hasOne(Quotations::class, ['id' => 'quotation_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * Gets the quotation name.
     *
     * @return string
     */
    public function getQuotationName()
    {
        return $this->quotation ? $this->quotation->id : '';
    }

    /**
     * Gets the service name.
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->service ? $this->service->name : '';
    }

}
