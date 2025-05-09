<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Services;

/**
 * ServicesSearch represents the model behind the search form of `app\models\Services`.
 */
class ServicesSearch extends Services
{   
    public $quotationTypeName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quotation_type_id'], 'integer'],
            [['name', 'unit', 'quotationTypeName'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'unit' => 'Unidad',
            'price' => 'Precio',
            'quotation_type_id' => 'Tipo de Cotización',
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
        $query = Services::find()
            ->joinWith(['quotationType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'name',
                    'unit',
                    'price',
                    'quotationTypeName' => [
                        'asc' => ['quotation_types.name' => SORT_ASC],
                        'desc' => ['quotation_types.name' => SORT_DESC],
                    ],
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
            'services.id' => $this->id,
            'services.quotation_type_id' => $this->quotation_type_id,
            'services.price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'services.name', $this->name])
            ->andFilterWhere(['like', 'services.unit', $this->unit])
            ->andFilterWhere(['like', 'quotation_types.name', $this->quotationTypeName]);

        return $dataProvider;
    }
}
