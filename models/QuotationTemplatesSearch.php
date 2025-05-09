<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuotationTemplates;

/**
 * QuotationTemplatesSearch represents the model behind the search form of `app\models\QuotationTemplates`.
 */
class QuotationTemplatesSearch extends QuotationTemplates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quotation_type_id', 'show_prices'], 'integer'],
            [['header_text', 'footer_text', 'logo_url', 'background_color', 'font_family', 'default_comments', 'terms_and_conditions', 'created_at', 'updated_at', 'quotationTypeName'], 'safe'],
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
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = QuotationTemplates::find()
            ->joinWith(['quotationType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'quotationTypeName' => [
                        'asc' => ['quotation_types.name' => SORT_ASC],
                        'desc' => ['quotation_types.name' => SORT_DESC],
                    ],
                    'header_text',
                    'footer_text',
                    'logo_url',
                    'background_color',
                    'font_family',
                    'default_comments',
                    'terms_and_conditions',
                    'show_prices',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'quotation_templates.id' => $this->id,
            'quotation_templates.quotation_type_id' => $this->quotation_type_id,
            'quotation_templates.show_prices' => $this->show_prices,
            'quotation_templates.created_at' => $this->created_at,
            'quotation_templates.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'quotation_templates.header_text', $this->header_text])
            ->andFilterWhere(['like', 'quotation_templates.footer_text', $this->footer_text])
            ->andFilterWhere(['like', 'quotation_templates.logo_url', $this->logo_url])
            ->andFilterWhere(['like', 'quotation_templates.background_color', $this->background_color])
            ->andFilterWhere(['like', 'quotation_templates.font_family', $this->font_family])
            ->andFilterWhere(['like', 'quotation_templates.default_comments', $this->default_comments])
            ->andFilterWhere(['like', 'quotation_templates.terms_and_conditions', $this->terms_and_conditions])
            ->andFilterWhere(['like', 'quotation_types.name', $this->quotationTypeName]);

        return $dataProvider;
    }
}
