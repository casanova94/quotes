<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "site_inspection_reports".
 *
 * @property int $id
 * @property int $quotation_id
 * @property int|null $technician_id
 * @property string|null $inspection_date
 * @property string|null $device_condition_notes
 * @property string|null $created_at
 *
 * @property Quotations $quotation
 * @property SiteInspectionObservations[] $siteInspectionObservations
 * @property Technicians $technician
 */
class SiteInspectionReports extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_inspection_reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['technician_id', 'device_condition_notes'], 'default', 'value' => null],
            [['quotation_id'], 'required'],
            [['quotation_id', 'technician_id'], 'integer'],
            [['inspection_date', 'created_at'], 'safe'],
            [['device_condition_notes'], 'string'],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotations::class, 'targetAttribute' => ['quotation_id' => 'id']],
            [['technician_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technicians::class, 'targetAttribute' => ['technician_id' => 'id']],
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
            'technician_id' => 'Técnico',
            'inspection_date' => 'Fecha de Inspección',
            'device_condition_notes' => 'Notas de condición del equipo',
            'created_at' => 'Created At',
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
     * Gets query for [[SiteInspectionObservations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiteInspectionObservations()
    {
        return $this->hasMany(SiteInspectionObservations::class, ['inspection_report_id' => 'id']);
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

    public function getObservations()
    {
        return $this->hasMany(SiteInspectionObservations::class, ['inspection_report_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();

        // Formatear la fecha al formato Y-m-d para el campo de tipo date
        if ($this->inspection_date) {
            $this->inspection_date = date('Y-m-d', strtotime($this->inspection_date));
        }
    }

}
