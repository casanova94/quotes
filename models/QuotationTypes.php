<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotation_types".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property QuotationTemplates $quotationTemplates
 * @property Quotations[] $quotations
 * @property Services[] $services
 */
class QuotationTypes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotation_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[QuotationTemplates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationTemplates()
    {
        return $this->hasOne(QuotationTemplates::class, ['quotation_type_id' => 'id']);
    }

    /**
     * Gets query for [[Quotations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotations::class, ['quotation_type_id' => 'id']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Services::class, ['quotation_type_id' => 'id']);
    }

}
