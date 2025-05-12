<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $unit
 * @property float $price
 * @property int $quotation_type_id
 *
 * @property QuotationDetails[] $quotationDetails
 * @property QuotationTypes $quotationType
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'unit', 'price', 'quotation_type_id'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['quotation_type_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 50],
            [['quotation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuotationTypes::class, 'targetAttribute' => ['quotation_type_id' => 'id']],
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
            'description' => 'Descripción',
            'unit' => 'Tipo',
            'price' => 'Precio',
            'quotation_type_id' => 'Tipo de Cotización',
            'quotationTypeName' => 'Tipo de Cotización',
        ];
    }

    /**
     * Gets query for [[QuotationDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDetails()
    {
        return $this->hasMany(QuotationDetails::class, ['service_id' => 'id']);
    }

    /**
     * Gets query for [[QuotationType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationType()
    {
        return $this->hasOne(QuotationTypes::class, ['id' => 'quotation_type_id']);
    }

    /**
     * Gets the quotation type name.
     *
     * @return string
     */
    public function getQuotationTypeName()
    {
        return $this->quotationType ? $this->quotationType->name : '';
    }

}
