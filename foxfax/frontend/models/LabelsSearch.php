<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LabelsSearch represents the model behind the search form about `frontend\models\Labels`.
 */
class LabelsSearch extends Labels
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position'], 'integer'],
            [['title', 'color', 'status'], 'safe'],
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
        $nAccountId = (!empty(Yii::$app->user->identity->parent_id)) ? Yii::$app->user->identity->parent_id : Yii::$app->user->identity->id;

        $query = Labels::find();

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
            'id'       => $this->id,
            'position' => $this->position,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['=', 'account_id', $nAccountId]);

        return $dataProvider;
    }
}
