<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuotationDetails;

/**
 * QuotationDetailsSearch represents the model behind the search form of `app\models\QuotationDetails`.
 */
class QuotationDetailsSearch extends QuotationDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quotation_id', 'service_id', 'quantity'], 'integer'],
            [['unit_price', 'subtotal'], 'number'],
            [['quotationName', 'serviceName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Cotización',
            'service_id' => 'Servicio',
            'quantity' => 'Cantidad',
            'unit_price' => 'Precio Unitario',
            'subtotal' => 'Subtotal',
            'quotationName' => 'Cotización',
            'serviceName' => 'Servicio',
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
        $query = QuotationDetails::find()
            ->joinWith(['quotation', 'service']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'quotationName' => [
                        'asc' => ['quotations.id' => SORT_ASC],
                        'desc' => ['quotations.id' => SORT_DESC],
                    ],
                    'serviceName' => [
                        'asc' => ['services.name' => SORT_ASC],
                        'desc' => ['services.name' => SORT_DESC],
                    ],
                    'quantity',
                    'unit_price',
                    'subtotal',
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'quotation_details.id' => $this->id,
            'quotation_details.quotation_id' => $this->quotation_id,
            'quotation_details.service_id' => $this->service_id,
            'quotation_details.quantity' => $this->quantity,
            'quotation_details.unit_price' => $this->unit_price,
            'quotation_details.subtotal' => $this->subtotal,
        ]);

        $query->andFilterWhere(['like', 'services.name', $this->serviceName]);

        return $dataProvider;
    }
}
