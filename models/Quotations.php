<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotations".
 *
 * @property int $id
 * @property int $client_id
 * @property int $quotation_type_id
 * @property int|null $technician_id
 * @property int $status_id
 * @property float|null $total_amount
 * @property string|null $custom_footer
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Clients $client
 * @property QuotationDetails[] $quotationDetails
 * @property QuotationTypes $quotationType
 * @property QuotationStatuses $status
 * @property Technicians $technician
 */
class Quotations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['technician_id', 'custom_footer'], 'default', 'value' => null],
            [['total_amount'], 'default', 'value' => 0.00],
            [['client_id', 'quotation_type_id', 'status_id'], 'required'],
            [['client_id', 'quotation_type_id', 'technician_id', 'status_id'], 'integer'],
            [['total_amount'], 'number'],
            [['custom_footer'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client_id' => 'id']],
            [['quotation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuotationTypes::class, 'targetAttribute' => ['quotation_type_id' => 'id']],
            [['technician_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technicians::class, 'targetAttribute' => ['technician_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuotationStatuses::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'quotation_type_id' => 'Quotation Type ID',
            'technician_id' => 'Technician ID',
            'status_id' => 'Status ID',
            'total_amount' => 'Total Amount',
            'custom_footer' => 'Custom Footer',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[QuotationDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDetails()
    {
        return $this->hasMany(QuotationDetails::class, ['quotation_id' => 'id']);
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
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(QuotationStatuses::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Technician]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTechnician()
    {
        return $this->hasOne(Technicians::class, ['id' => 'technician_id']);
    }

}
