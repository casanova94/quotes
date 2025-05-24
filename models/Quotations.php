<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotations".
 *
 * @property int $id
 * @property string|null $name
 * @property int $client_id
 * @property int $quotation_type_id
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
            [['custom_footer'], 'default', 'value' => null],
            [['total_amount'], 'default', 'value' => 0.00],
            [['client_id', 'quotation_type_id', 'status_id'], 'required'],
            [['client_id', 'quotation_type_id', 'status_id'], 'integer'],
            [['total_amount'], 'number'],
            [['custom_footer', 'name'], 'string'],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['client_id' => 'id']],
            [['quotation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuotationTypes::class, 'targetAttribute' => ['quotation_type_id' => 'id']],
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
            'name' => 'Nombre de la Cotización',
            'client_id' => 'Cliente',
            'quotation_type_id' => 'Tipo de Cotización',
            'status_id' => 'Estado',
            'total_amount' => 'Monto Total',
            'custom_footer' => 'Pie de Página Personalizado',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
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

}
