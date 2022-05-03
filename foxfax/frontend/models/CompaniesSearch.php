<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CompaniesSearch represents the model behind the search form about `app\models\Companies`.
 */
class CompaniesSearch extends Companies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'alert_email', 'alert_sms', 'alert_default', 'country_id', 'shared', 'last_modify'], 'integer'],
            // [['title', 'adress', 'phone', 'email', 'description', 'sender_name', 'sender_email', 'sms_time', 'date_added'], 'safe'],
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
        $query = Companies::find()->where(['=', 'account_id', $nAccountId]);

        $query->joinWith([
            'country',
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

        $dataProvider->sort->attributes['countryName'] = [
            'asc'  => ['lic_countries.title_en' => SORT_ASC],
            'desc' => ['lic_countries.title_en' => SORT_DESC],
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
            ['like', 'phone', $this->title_en],
            ['like', 'email', $this->title_en],
            ['like', 'description', $this->title_en],
            ['like', 'adress', $this->title_en],
            ['like', 'sender_name', $this->title_en],
            ['like', 'sender_email', $this->title_en],
            ['like', 'alert_email', $this->title_en],
            ['like', 'alert_sms', $this->title_en],
            ['like', 'alert_default', $this->title_en],
            // ['like', 'country_id', $this->title_en],
            ['like', 'sms_time', $this->title_en],
            ['like', 'shared', $this->title_en],
            ['like', 'date_added', $this->title_en],
            ['like', 'last_modify', $this->title_en],
            ['like', 'lic_companies.title_en', $this->title_en],
            ['like', 'lic_companies.title_fr', $this->title_en],
            ['like', 'lic_countries.title_en', $this->title_en],
            ['like', 'lic_countries.title_fr', $this->title_en],
        ]);

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'alert_email' => $this->alert_email,
        //     'alert_sms' => $this->alert_sms,
        //     'alert_default' => $this->alert_default,
        //     'country_id' => $this->country_id,
        //     'sms_time' => $this->sms_time,
        //     'shared' => $this->shared,
        //     'date_added' => $this->date_added,
        //     'last_modify' => $this->last_modify,
        // ]);

        // $query->andFilterWhere(['like', 'title', $this->title])
        //     ->andFilterWhere(['like', 'adress', $this->adress])
        //     ->andFilterWhere(['like', 'phone', $this->phone])
        //     ->andFilterWhere(['like', 'email', $this->email])
        //     ->andFilterWhere(['like', 'description', $this->description])
        //     ->andFilterWhere(['like', 'sender_name', $this->sender_name])
        //     ->andFilterWhere(['like', 'sender_email', $this->sender_email]);

        return $dataProvider;
    }
}
