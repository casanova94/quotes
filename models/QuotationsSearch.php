<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quotations;

/**
 * QuotationsSearch represents the model behind the search form of `app\models\Quotations`.
 */
class QuotationsSearch extends Quotations
{   
    public $clientName;
    public $quotationTypeName;
    public $technicianName;
    public $statusName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'quotation_type_id', 'technician_id', 'status_id'], 'integer'],
            [['total_amount'], 'number'],
            [['custom_footer', 'created_at', 'updated_at'], 'safe'],
            [['clientName', 'quotationTypeName', 'technicianName', 'statusName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Cliente',
            'quotation_type_id' => 'Tipo de Cotización',
            'technician_id' => 'Técnico',
            'status_id' => 'Estado',
            'total_amount' => 'Monto Total',
            'custom_footer' => 'Pie de Página Personalizado',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'clientName' => 'Cliente',
            'quotationTypeName' => 'Tipo de Cotización',
            'technicianName' => 'Técnico',
            'statusName' => 'Estado',
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
        $query = Quotations::find()
            ->joinWith(['client', 'quotationType', 'technician', 'status']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'clientName' => [
                        'asc' => ['clients.name' => SORT_ASC],
                        'desc' => ['clients.name' => SORT_DESC],
                    ],
                    'quotationTypeName' => [
                        'asc' => ['quotation_types.name' => SORT_ASC],
                        'desc' => ['quotation_types.name' => SORT_DESC],
                    ],
                    'technicianName' => [
                        'asc' => ['technicians.name' => SORT_ASC],
                        'desc' => ['technicians.name' => SORT_DESC],
                    ],
                    'statusName' => [
                        'asc' => ['quotation_statuses.name' => SORT_ASC],
                        'desc' => ['quotation_statuses.name' => SORT_DESC],
                    ],
                    'total_amount',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
           // 'quotations.id' => $this->id,
            'quotations.client_id' => $this->client_id,
            'quotations.quotation_type_id' => $this->quotation_type_id,
            'quotations.technician_id' => $this->technician_id,
            'quotations.status_id' => $this->status_id,
            'quotations.total_amount' => $this->total_amount,
            //'quotations.created_at' => $this->created_at,
            'quotations.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'quotations.custom_footer', $this->custom_footer])
            ->andFilterWhere(['like', 'clients.name', $this->clientName])
            ->andFilterWhere(['like', 'quotation_types.name', $this->quotationTypeName])
            ->andFilterWhere(['like', 'technicians.name', $this->technicianName])
            ->andFilterWhere(['like', 'quotation_statuses.name', $this->statusName])
            ->andFilterWhere(['like', 'quotations.id', $this->id]);

        
        if (!empty($this->created_at)) {
                $fecha = $this->created_at;
                $query->andFilterWhere(['between', 'quotations.created_at', "$fecha 00:00:00", "$fecha 23:59:59"]);
        }

        return $dataProvider;
    }
}
