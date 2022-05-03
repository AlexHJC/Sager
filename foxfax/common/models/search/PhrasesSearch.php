<?php

namespace common\models\search;

use common\models\Phrases;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PhrasesSearch represents the model behind the search form about `common\models\Phrases`.
 */
class PhrasesSearch extends Phrases
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'alias', 'title_ru', 'title_en', 'title_ro', 'title_fr', 'title_de'], 'safe'],
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
        $query = Phrases::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_en', $this->title_en])
            ->andFilterWhere(['like', 'title_ro', $this->title_ro])
            ->andFilterWhere(['like', 'title_fr', $this->title_fr])
            ->andFilterWhere(['like', 'title_de', $this->title_de]);

        return $dataProvider;
    }
}
