<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "service_orders".
 *
 * @property int $id
 * @property int $quotation_id
 * @property string $creation_date
 * @property string $status
 * @property string|null $notes
 * @property string|null $scheduledDateTime
 * @property int|null $technician_id
 *
 * @property Quotations $quotation
 * @property Technicians $technician
 */
class ServiceOrder extends ActiveRecord
{
    const STATUS_PENDING = 'Pendiente';
    const STATUS_IN_PROGRESS = 'En proceso';
    const STATUS_COMPLETED = 'Finalizado';
    const STATUS_CANCELLED = 'Cancelado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creation_date'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_id'], 'required'],
            [['quotation_id', 'technician_id'], 'integer'],
            [['creation_date', 'scheduledDateTime'], 'safe'],
            [['notes'], 'string'],
            [['status'], 'string', 'max' => 20],
            [['status'], 'in', 'range' => [
                self::STATUS_PENDING,
                self::STATUS_IN_PROGRESS,
                self::STATUS_COMPLETED,
                self::STATUS_CANCELLED
            ]],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotations::class, 'targetAttribute' => ['quotation_id' => 'id']],
            [['technician_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technicians::class, 'targetAttribute' => ['technician_id' => 'id']],
            [['quotation_id'], 'validateQuotationStatus'],
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
            'creation_date' => 'Fecha de Creación',
            'status' => 'Estado',
            'notes' => 'Notas',
            'scheduledDateTime' => 'Fecha y Hora Programada',
            'technician_id' => 'Técnico',
        ];
    }

    /**
     * Validates that the quotation status is valid for creating a service order
     */
    public function validateQuotationStatus($attribute, $params)
    {
        $quotation = Quotations::findOne($this->quotation_id);
        if ($quotation && $quotation->status !== 'Aceptada') {
            $this->addError($attribute, 'Solo se pueden crear órdenes de servicio para cotizaciones Aceptadas.');
        }
    }

    /**
     * Gets query for [[Quotation]]
     */
    public function getQuotation()
    {
        return $this->hasOne(Quotations::class, ['id' => 'quotation_id']);
    }

    /**
     * Gets query for [[Technician]]
     */
    public function getTechnician()
    {
        return $this->hasOne(Technicians::class, ['id' => 'technician_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        //$this->status = self::STATUS_PENDING;
    }
} 