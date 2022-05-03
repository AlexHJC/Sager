<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PaymentsSearch represents the model behind the search form about `frontend\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'plan_id', 'plan_user_limit'], 'integer'],
            [['payment_cycle', 'payer_id', 'payment_id', 'payment_state', 'payment_currency', 'payment_method', 'invoice_number', 'status', 'payer_email', 'payer_first_name', 'payer_last_name', 'payer_phone', 'payer_country_code'], 'safe'],
            [['payment_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Payments::find();

        // add conditions that should always apply here

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
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'plan_id'         => $this->plan_id,
            'payment_amount'  => $this->payment_amount,
            'plan_user_limit' => $this->plan_user_limit,
        ]);

        $query->andFilterWhere(['like', 'payment_cycle', $this->payment_cycle])
            ->andFilterWhere(['like', 'payer_id', $this->payer_id])
            ->andFilterWhere(['like', 'payment_id', $this->payment_id])
            ->andFilterWhere(['like', 'payment_state', 'approved'])
            ->andFilterWhere(['like', 'payment_currency', $this->payment_currency])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'payer_email', $this->payer_email])
            ->andFilterWhere(['like', 'payer_first_name', $this->payer_first_name])
            ->andFilterWhere(['like', 'payer_last_name', $this->payer_last_name])
            ->andFilterWhere(['like', 'payer_phone', $this->payer_phone])
            ->andFilterWhere(['like', 'payer_country_code', $this->payer_country_code])
            ->orderBy('id desc');

        return $dataProvider;
    }
}
