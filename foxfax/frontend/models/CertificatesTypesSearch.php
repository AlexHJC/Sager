<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CertificatesTypesSearch represents the model behind the search form about `frontend\models\CertificatesTypes`.
 */
class CertificatesTypesSearch extends CertificatesTypes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'title', 'position'], 'integer'],
            // [['status'], 'safe'],
            [['title_en'], 'safe'],
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
        $query = CertificatesTypes::find()->alias('ct');

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
        //     'title' => $this->title,
        //     'position' => $this->position,
        // ]);

        $query->andFilterWhere([
            'or',
            ['like', 'ct.status', $this->title_en],
            ['like', 'ct.title_en', $this->title_en],
            ['like', 'ct.title_fr', $this->title_en],
            ['like', 'ct.position', $this->title_en],
        ]);

        // $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
