<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotation_statuses".
 *
 * @property int $id
 * @property string $name
 * @property string|null $color_code
 *
 * @property Quotations[] $quotations
 */
class QuotationStatuses extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotation_statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_code'], 'default', 'value' => null],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['color_code'], 'string', 'max' => 20],
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
            'color_code' => 'Código de Color',
        ];
    }

    /**
     * Gets query for [[Quotations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotations::class, ['status_id' => 'id']);
    }

}
