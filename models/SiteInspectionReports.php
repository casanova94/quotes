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
            'quotation_id' => 'Quotation ID',
            'technician_id' => 'Technician ID',
            'inspection_date' => 'Inspection Date',
            'device_condition_notes' => 'Device Condition Notes',
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

}
