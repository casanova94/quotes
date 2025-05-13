<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "site_inspection_observations".
 *
 * @property int $id
 * @property int $inspection_report_id
 * @property string $title
 * @property string|null $description
 * @property string|null $photo_url
 *
 * @property SiteInspectionReports $inspectionReport
 */
class SiteInspectionObservations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_inspection_observations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'photo_url'], 'default', 'value' => null],
            [['inspection_report_id', 'title'], 'required'],
            [['inspection_report_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['photo_url'], 'string', 'max' => 500],
            [['inspection_report_id'], 'exist', 'skipOnError' => true, 'targetClass' => SiteInspectionReports::class, 'targetAttribute' => ['inspection_report_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inspection_report_id' => 'Inspection Report ID',
            'title' => 'Title',
            'description' => 'Description',
            'photo_url' => 'Photo Url',
        ];
    }

    /**
     * Gets query for [[InspectionReport]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInspectionReport()
    {
        return $this->hasOne(SiteInspectionReports::class, ['id' => 'inspection_report_id']);
    }

        public static function createMultiple($data)
{
    $models = [];
    foreach ($data as $index => $item) {
        $model = new self();
        $model->load(['SiteInspectionObservations' => $item]);
        $models[] = $model;
    }
    return $models;
}

}
