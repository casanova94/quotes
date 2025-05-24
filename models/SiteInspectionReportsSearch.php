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
    public $service_order_number;
    public $technician_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_order_id', 'technician_id'], 'integer'],
            [['inspection_date', 'device_condition_notes', 'created_at'], 'safe'],
            [['service_order_number', 'technician_name'], 'safe'],
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
        $query = SiteInspectionReports::find()
            ->joinWith(['serviceOrder', 'technician']);

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
            'site_inspection_reports.id' => $this->id,
            'site_inspection_reports.service_order_id' => $this->service_order_id,
            'site_inspection_reports.technician_id' => $this->technician_id,
            'site_inspection_reports.inspection_date' => $this->inspection_date,
            'site_inspection_reports.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'site_inspection_reports.device_condition_notes', $this->device_condition_notes])
            ->andFilterWhere(['like', 'service_orders.id', $this->service_order_number])
            ->andFilterWhere(['like', 'technicians.name', $this->technician_name]);

        return $dataProvider;
    }
}
