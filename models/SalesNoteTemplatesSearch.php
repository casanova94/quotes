<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesNoteTemplates;

/**
 * SalesNoteTemplatesSearch represents the model behind the search form of `app\models\SalesNoteTemplates`.
 */
class SalesNoteTemplatesSearch extends SalesNoteTemplates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quotation_type_id'], 'integer'],
            [['logo', 'header_text', 'company_text', 'bottom_text', 'terms_and_conditions', 'created_at', 'updated_at'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SalesNoteTemplates::find();

        // add conditions that should always apply here
        $query->joinWith(['quotationType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quotation_type_id' => $this->quotation_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'header_text', $this->header_text])
            ->andFilterWhere(['like', 'company_text', $this->company_text])
            ->andFilterWhere(['like', 'bottom_text', $this->bottom_text])
            ->andFilterWhere(['like', 'terms_and_conditions', $this->terms_and_conditions]);

        return $dataProvider;
    }
} 