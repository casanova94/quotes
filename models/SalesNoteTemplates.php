<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "sales_note_templates".
 *
 * @property int $id
 * @property int $quotation_type_id
 * @property string|null $logo
 * @property string|null $header_text
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property QuotationTypes $quotationType
 */
class SalesNoteTemplates extends \yii\db\ActiveRecord
{
    public $logoFile; // Atributo para manejar la subida del archivo

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_note_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_type_id'], 'required'],
            [['quotation_type_id'], 'integer'],
            [['header_text'], 'string'],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['logo'], 'string', 'max' => 500],
            [['quotation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuotationTypes::class, 'targetAttribute' => ['quotation_type_id' => 'id']],
            [['logoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2], // 2MB
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
            'logo' => 'Logo',
            'logoFile' => 'Logo',
            'header_text' => 'Texto de Encabezado',
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
     * Gets query for [[QuotationType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationType()
    {
        return $this->hasOne(QuotationTypes::class, ['id' => 'quotation_type_id']);
    }

    /**
     * Sube el archivo de logo
     * @return boolean
     */
    public function uploadLogo()
    {
        if ($this->logoFile) {
            $uploadPath = Yii::getAlias('@webroot/uploads/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = uniqid() . '.' . $this->logoFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->logoFile->saveAs($filePath)) {
                // Eliminar el logo anterior si existe
                $this->deleteLogo();
                
                $this->logo = 'uploads/' . $fileName;
                return true;
            }
        }
        return false;
    }

    /**
     * Elimina el archivo de logo
     * @return boolean
     */
    public function deleteLogo()
    {
        if ($this->logo) {
            $filePath = Yii::getAlias('@webroot/') . $this->logo;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $this->logo = null;
            return true;
        }
        return false;
    }

    /**
     * Obtiene la URL del logo
     * @return string|null
     */
    public function getLogoUrl()
    {
        if ($this->logo) {
            $filePath = Yii::getAlias('@webroot/') . $this->logo;
            if (file_exists($filePath)) {
                return Url::to('@web/' . $this->logo, true);
            }
        }
        return null;
    }

    /**
     * Obtiene la configuración inicial para el widget FileInput
     * @return array
     */
    public function getLogoInitialPreview()
    {
        $url = $this->getLogoUrl();
        if ($url) {
            return [$url];
        }
        return [];
    }

    /**
     * Obtiene la configuración de datos iniciales para el widget FileInput
     * @return array
     */
    public function getLogoInitialPreviewConfig()
    {
        if ($this->logo) {
            $filePath = Yii::getAlias('@webroot/') . $this->logo;
            if (file_exists($filePath)) {
                return [
                    [
                        'caption' => basename($this->logo),
                        'size' => filesize($filePath),
                        'url' => Url::to(['/sales-note-templates/delete-logo', 'id' => $this->id]),
                        'key' => $this->id,
                        'extra' => ['id' => $this->id]
                    ]
                ];
            }
        }
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Si hay un archivo nuevo, asegurarse de que se suba antes de guardar
        if ($this->logoFile) {
            if (!$this->uploadLogo()) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleteLogo();
            return true;
        }
        return false;
    }
} 