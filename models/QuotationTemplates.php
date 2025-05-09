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
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
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
            'quotation_type_id' => 'Tipo de Cotización',
            'header_text' => 'Texto de Encabezado',
            'footer_text' => 'Texto de Pie de Página',
            'logo_url' => 'URL del Logo',
            'background_color' => 'Color de Fondo',
            'font_family' => 'Familia de Fuente',
            'default_comments' => 'Comentarios por Defecto',
            'terms_and_conditions' => 'Términos y Condiciones',
            'show_prices' => 'Mostrar Precios',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'quotationTypeName' => 'Tipo de Cotización',
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
