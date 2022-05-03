<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PeriodsSearch represents the model behind the search form about `frontend\models\Periods`.
 */
class PeriodsSearch extends Periods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'days'], 'integer'],
            // [['title'], 'safe'],
            [['position'], 'safe'],
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
        $query = Periods::find()->where(['=', 'account_id', $nAccountId]);

        // add conditions that should always apply here

        $cw = Yii::$app->request->get('cw');
        if (!isset($cw)) {
            if (Yii::$app->session->get('cw') !== null) {
                $cw = Yii::$app->session->get('cw');
            } else {
                $cw = 10;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => $cw,],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'days' => $this->days,
        // ]);
        // $query->andFilterWhere(['like', 'title', $this->title]);


        $query->andFilterWhere([
            'or',
            ['like', 'days', $this->title],
            ['like', 'title', $this->title],
            ['like', 'position', $this->title],
        ]);

        return $dataProvider;
    }
}
