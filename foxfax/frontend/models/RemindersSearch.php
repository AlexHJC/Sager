<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RemindersSearch represents the model behind the search form about `frontend\models\Reminders`.
 */
class RemindersSearch extends Reminders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'certificat_id', 'product_id', 'company_id', 'certificat_type'], 'integer'],
            // [['date_alert', 'status', 'state', 'comment'], 'safe'],
            [['state'], 'safe'],
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
        $query = Reminders::find();

        $query->joinWith([
            'certificat',
            'product',
            'company',
            'type',
            'label'
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
            'sort'       => [
                'defaultOrder' => [
                    'date_alert' => SORT_DESC,
                ]
            ]
        ]);

        $dataProvider->sort->attributes['certificatName'] = [
            'asc'  => ['lic_certificates.title_en' => SORT_ASC],
            'desc' => ['lic_certificates.title_en' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['productName'] = [
            'asc'  => ['lic_products.title_en' => SORT_ASC],
            'desc' => ['lic_products.title_en' => SORT_DESC],
        ];


        $dataProvider->sort->attributes['companyName'] = [
            'asc'  => ['lic_companies.title_en' => SORT_ASC],
            'desc' => ['lic_companies.title_en' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['typeName'] = [
            'asc'  => ['lic_certificates_types_items.title_en' => SORT_ASC],
            'desc' => ['lic_certificates_types_items.title_en' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'certificat_id' => $this->certificat_id,
        //     'product_id' => $this->product_id,
        //     'company_id' => $this->company_id,
        //     'certificat_type' => $this->certificat_type,
        //     'date_alert' => $this->date_alert,
        // ]);

        // $query->andFilterWhere(['like', 'date_alert', $this->status])
        //     ->andFilterWhere(['like', 'state', $this->state])
        //     ->andFilterWhere(['like', 'comment', $this->comment]);

        $nAccountId = (!empty(Yii::$app->user->identity->parent_id)) ? Yii::$app->user->identity->parent_id : Yii::$app->user->identity->id;
        $query->andWhere(['=', 'lic_companies.account_id', $nAccountId]);

        $query->andFilterWhere([
            'or',
            // ['like', 'id', $this->state],
            ['like', 'lic_reminders.certificat_id', $this->state],
            ['like', 'lic_reminders.product_id', $this->state],
            ['like', 'lic_reminders.company_id', $this->state],
            ['like', 'lic_reminders.certificat_type', $this->state],
            ['like', 'date_alert', $this->state],
            ['like', 'state', $this->state],
            ['like', 'comment', $this->state],

            ['like', 'lic_certificates.title_en', $this->state],
            ['like', 'lic_certificates.title_fr', $this->state],

            ['like', 'lic_products.title_en', $this->state],
            ['like', 'lic_products.title_fr', $this->state],

            ['like', 'lic_companies.title_en', $this->state],
            ['like', 'lic_companies.title_fr', $this->state],

            ['like', 'lic_certificates_types_items.title_en', $this->state],
            ['like', 'lic_certificates_types_items.title_fr', $this->state],
        ]);

        return $dataProvider;
    }
}
