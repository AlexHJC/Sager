<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AlertsSearch represents the model behind the search form about `frontend\models\Alerts`.
 */
class AlertsSearch extends Alerts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'certificat_id', 'label_id', 'notification_id', 'period_id', 'position'], 'integer'],
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

        $query = Alerts::find();

        $query->joinWith([
            'certificat',
            'label',
            'notification',
            'period',
        ]);

        $query->leftJoin('{{%certificates}} cert', 'cert.parent_id = {{%alerts}}.certificat_id');


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
            'sort'       => ['defaultOrder' => ['certificat_id' => SORT_ASC]]
        ]);


        $dataProvider->sort->attributes['certificatName'] = [
            'asc'  => ['cert.title_en' => SORT_ASC],
            'desc' => ['cert.title_en' => SORT_DESC],
        ];


        $dataProvider->sort->attributes['labelName'] = [
            'asc'  => ['{{%labels}}.title' => SORT_ASC],
            'desc' => ['{{%labels}}.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['notificationName'] = [
            'asc'  => ['{{%notifications}}.title_en' => SORT_ASC],
            'desc' => ['{{%notifications}}.title_en' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['periodName'] = [
            'asc'  => ['{{%periods}}.title' => SORT_ASC],
            'desc' => ['{{%periods}}.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'or',
            ['like', '{{%alerts}}.id', $this->position],
            ['like', '{{%alerts}}.position', $this->position],
            ['like', 'cert.title_en', $this->position],
            ['like', 'cert.title_fr', $this->position],
            ['like', '{{%labels}}.title', $this->position],
            ['like', '{{%notifications}}.title_en', $this->position],
            ['like', '{{%notifications}}.title_fr', $this->position],
            ['like', '{{%periods}}.title', $this->position],
            ['=', 'cert.account_id', $nAccountId],
        ]);

        // // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'certificat_id' => $this->certificat_id,
        //     'label_id' => $this->label_id,
        //     'notification_id' => $this->notification_id,
        //     'period_id' => $this->period_id,
        //     'position' => $this->position,
        // ]);
        // echo $query->createCommand()->sql;
        return $dataProvider;
    }
}
