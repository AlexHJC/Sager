<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CertificatesSearch represents the model behind the search form about `frontend\models\Certificates`.
 */
class CertificatesSearch extends Certificates
{
    /**
     * @inheritdoc
     */
    // public $type;

    public function rules()
    {
        return [
            // [['id', 'type_id', 'modify_by', 'comments'], 'integer'],
            // [['added', 'expire', 'valable', 'attachment', 'title', 'type'], 'safe'],
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
        $query = Certificates::find()->alias('cert');

        // add conditions that should always apply here
        $query->joinWith([
            'ty' =>'type',
            'pa' =>'parent',
            'u' => 'user',
        ]);

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
            'sort'       => ['defaultOrder' => ['parent_id' => SORT_ASC]]
        ]);


        $dataProvider->sort->attributes['typeName'] = [
            'asc'  => ['pa.title_en' => SORT_ASC],
            'desc' => ['pa.title_en' => SORT_DESC],
        ];


        // $dataProvider->sort->attributes['parent_id'] = [
        //     'asc' => ['lic_certificates_types.title_en' => SORT_ASC],
        //     'desc' => ['lic_certificates_types.title_en' => SORT_DESC],
        // ];


        $dataProvider->sort->attributes['userName'] = [
            'asc'  => ['u.username' => SORT_ASC],
            'desc' => ['u.username' => SORT_DESC],
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
        //     'type_id' => $this->type_id,
        //     'added' => $this->added,
        //     'expire' => $this->expire,
        //     'modify_by' => $this->modify_by,
        //     'comments' => $this->comments,
        //     // 'lic_certificates.title' => $this->title,
        //     // 'lic_certificates_types.title' => $this->type,
        // ]);

        $query->andFilterWhere([
            'or',
            ['like', 'cert.type_id', $this->title_en],
            ['like', 'cert.added', $this->title_en],
            ['like', 'cert.expire', $this->title_en],
            ['like', 'cert.modify_by', $this->title_en],
            ['like', 'cert.comments', $this->title_en],
            ['like', 'cert.valable', $this->title_en],
            ['like', 'cert.title_en', $this->title_en],
            ['like', 'cert.title_fr', $this->title_en],
            ['like', 'pa.title_en', $this->title_en],
            ['like', 'pa.title_fr', $this->title_en],
            ['like', 'u.username', $this->title_en],
            ['=', 'cert.account_id', $nAccountId],
        ]);

        // $query->andFilterWhere(['like', 'valable', $this->valable])
        //     ->andFilterWhere(['like', 'attachment', $this->attachment])
        //     ->andFilterWhere(['like', 'lic_certificates.title', $this->title])
        //     ->andFilterWhere(['like', 'lic_certificates_types.title', $this->type]);

        return $dataProvider;
    }
}
