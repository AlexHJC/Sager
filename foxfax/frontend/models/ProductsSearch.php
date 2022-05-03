<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductsSearch represents the model behind the search form about `frontend\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'company_id', 'certificat_id'], 'integer'],
            // [['cod', 'title', 'lot'], 'safe'],
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
        $nAccountId = (!empty(Yii::$app->user->identity->parent_id)) ? Yii::$app->user->identity->parent_id : Yii::$app->user->identity->id;
        $query = Products::find()->where(['=', 'account_id', $nAccountId]);

        $query->joinWith([
            // 'company',
            // 'certificat',
        ]);

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

        // $dataProvider->sort->attributes['companyName'] = [
        //     'asc' => ['lic_companies.title' => SORT_ASC],
        //     'desc' => ['lic_companies.title' => SORT_DESC],
        // ];

        // $dataProvider->sort->attributes['certificatName'] = [
        //     'asc' => ['lic_certificates.title' => SORT_ASC],
        //     'desc' => ['lic_certificates.title' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
                'or',
                ['like', 'cod', $this->title_en],
                ['like', 'title_en', $this->title_en],
                ['like', 'title_fr', $this->title_en],
                ['like', 'lot', $this->title_en],
                // ['like', 'lic_products.title', $this->title],
                // ['like', 'lic_companies.title', $this->title],
                // ['like', 'lic_certificates.title', $this->title],
            ]
        );

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'company_id' => $this->company_id,
        //     'certificat_id' => $this->certificat_id,
        // ]);

        // $query->andFilterWhere(['like', 'cod', $this->cod])
        //     ->andFilterWhere(['like', 'title', $this->title])
        //     ->andFilterWhere(['like', 'lot', $this->lot]);

        return $dataProvider;
    }
}
