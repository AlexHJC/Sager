<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PlanSearch represents the model behind the search form about `frontend\models\Plan`.
 */
class PlanSearch extends Plan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'plan_doc_limit', 'plan_user_limit'], 'integer'],
            [['plan_slug', 'plan_title'], 'safe'],
            [['plan_price_year', 'plan_price_month'], 'number'],
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
        $query = Plan::find();

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
            'id'               => $this->id,
            'plan_price_year'  => $this->plan_price_year,
            'plan_price_month' => $this->plan_price_month,
            'plan_doc_limit'   => $this->plan_doc_limit,
            'plan_user_limit'  => $this->plan_user_limit,
        ]);

        $query->andFilterWhere(['like', 'plan_slug', $this->plan_slug])
            ->andFilterWhere(['like', 'plan_title', $this->plan_title]);

        return $dataProvider;
    }
}
