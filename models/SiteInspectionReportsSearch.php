<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteInspectionReports;

/**
 * SiteInspectionReportsSearch represents the model behind the search form of `app\models\SiteInspectionReports`.
 */
class SiteInspectionReportsSearch extends SiteInspectionReports
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quotation_id', 'technician_id'], 'integer'],
            [['inspection_date', 'device_condition_notes', 'created_at'], 'safe'],
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
        $query = SiteInspectionReports::find();

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
            'quotation_id' => $this->quotation_id,
            'technician_id' => $this->technician_id,
            'inspection_date' => $this->inspection_date,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'device_condition_notes', $this->device_condition_notes]);

        return $dataProvider;
    }
}
