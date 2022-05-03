<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CertificatesTypesItemsSearch represents the model behind the search form about
 * `frontend\models\CertificatesTypesItems`.
 */
class CertificatesTypesItemsSearch extends CertificatesTypesItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'parent_id', 'position'], 'integer'],
            // [['title_en', 'title_fr', 'status'], 'safe'],
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
        $query = CertificatesTypesItems::find();

        $query->joinWith([
            'type',
        ]);

        $cw = Yii::$app->request->get('cw');
        if (!isset($cw)) {
            if (Yii::$app->session->get('cw') !== null) {
                $cw = Yii::$app->session->get('cw');
            } else {
                $cw = 10;
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => $cw,],
        ]);

        $dataProvider->sort->attributes['typeName'] = [
            'asc'  => ['lic_certificates_types.title_en' => SORT_ASC],
            'desc' => ['lic_certificates_types.title_en' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere([
            'or',
            // ['like', 'status', $this->title_en],
            // ['like', 'position', $this->title_en],
            ['like', 'lic_certificates_types_items.title_en', $this->title_en],
            ['like', 'lic_certificates_types_items.title_fr', $this->title_en],
            ['like', 'lic_certificates_types_items.status', $this->title_en],
            ['like', 'lic_certificates_types_items.position', $this->title_en],
            ['like', 'lic_certificates_types.title_en', $this->title_en],
            ['like', 'lic_certificates_types.title_fr', $this->title_en],
            ['like', 'lic_certificates_types.status', $this->title_en],
            ['like', 'lic_certificates_types.position', $this->title_en],
        ]);

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'parent_id' => $this->parent_id,
        //     'position' => $this->position,
        // ]);

        // $query->andFilterWhere(['like', 'title_en', $this->title_en])
        //     ->andFilterWhere(['like', 'title_fr', $this->title_fr])
        //     ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
