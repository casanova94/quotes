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
            [['header_text', 'footer_text', 'logo_url', 'background_color', 'font_family', 'default_comments', 'terms_and_conditions', 'created_at', 'updated_at'], 'safe'],
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
        $query = QuotationTemplates::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quotation_type_id' => $this->quotation_type_id,
            'show_prices' => $this->show_prices,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'header_text', $this->header_text])
            ->andFilterWhere(['like', 'footer_text', $this->footer_text])
            ->andFilterWhere(['like', 'logo_url', $this->logo_url])
            ->andFilterWhere(['like', 'background_color', $this->background_color])
            ->andFilterWhere(['like', 'font_family', $this->font_family])
            ->andFilterWhere(['like', 'default_comments', $this->default_comments])
            ->andFilterWhere(['like', 'terms_and_conditions', $this->terms_and_conditions]);

        return $dataProvider;
    }
}
