<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SubscriptionSearch represents the model behind the search form about `frontend\models\Subscription`.
 */
class SubscriptionSearch extends Subscription
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'plan_id', 'purchased_at', 'start_at', 'end_at'], 'integer'],
            [['plan_cycle'], 'safe'],
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
        $query = Subscription::find();

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
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'plan_id'      => $this->plan_id,
            'purchased_at' => $this->purchased_at,
            'start_at'     => $this->start_at,
            'end_at'       => $this->end_at,
        ]);

        $query->andFilterWhere(['like', 'plan_cycle', $this->plan_cycle]);

        return $dataProvider;
    }
}
