<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quotation_templates".
 *
 * @property int $id
 * @property int $quotation_type_id
 * @property string|null $header_text
 * @property string|null $footer_text
 * @property string|null $logo_url
 * @property string|null $background_color
 * @property string|null $font_family
 * @property string|null $default_comments
 * @property string|null $terms_and_conditions
 * @property int|null $show_prices
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property QuotationTypes $quotationType
 */
class QuotationTemplates extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotation_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['header_text', 'footer_text', 'logo_url', 'background_color', 'font_family', 'default_comments', 'terms_and_conditions'], 'default', 'value' => null],
            [['show_prices'], 'default', 'value' => 1],
            [['quotation_type_id'], 'required'],
            [['quotation_type_id', 'show_prices'], 'integer'],
            [['header_text', 'footer_text', 'default_comments', 'terms_and_conditions'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['logo_url'], 'string', 'max' => 500],
            [['background_color'], 'string', 'max' => 20],
            [['font_family'], 'string', 'max' => 100],
            [['quotation_type_id'], 'unique'],
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
            'quotation_type_id' => 'Quotation Type ID',
            'header_text' => 'Header Text',
            'footer_text' => 'Footer Text',
            'logo_url' => 'Logo Url',
            'background_color' => 'Background Color',
            'font_family' => 'Font Family',
            'default_comments' => 'Default Comments',
            'terms_and_conditions' => 'Terms And Conditions',
            'show_prices' => 'Show Prices',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

}
