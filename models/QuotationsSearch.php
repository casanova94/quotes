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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'quotation_type_id'], 'integer'],
            [['total_amount'], 'number'],
            [['custom_footer', 'created_at', 'updated_at', 'status'], 'safe'],
            [['clientName', 'quotationTypeName', 'name'], 'safe'],
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
            'status' => 'Estado',
            'total_amount' => 'Monto Total',
            'custom_footer' => 'Pie de Página Personalizado',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'clientName' => 'Cliente',
            'quotationTypeName' => 'Tipo de Cotización',
            'name' => 'Nombre',
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
            ->joinWith(['client', 'quotationType']);

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
                    'status',
                    'name',
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

        $query->andFilterWhere([
            'quotations.client_id' => $this->client_id,
            'quotations.quotation_type_id' => $this->quotation_type_id,
            'quotations.status' => $this->status,
            'quotations.total_amount' => $this->total_amount,
            'quotations.updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like', 'quotations.custom_footer', $this->custom_footer])
            ->andFilterWhere(['like', 'clients.name', $this->clientName])
            ->andFilterWhere(['like', 'quotation_types.name', $this->quotationTypeName])
            ->andFilterWhere(['like', 'quotations.id', $this->id])
            ->andFilterWhere(['like', 'quotations.name', $this->name]);

        if (!empty($this->created_at)) {
            $fecha = $this->created_at;
            $query->andFilterWhere(['between', 'quotations.created_at', "$fecha 00:00:00", "$fecha 23:59:59"]);
        }

        return $dataProvider;
    }
}
