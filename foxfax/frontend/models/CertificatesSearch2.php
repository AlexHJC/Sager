<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

// use \common\models\User;

/**
 * CertificatesSearch represents the model behind the search form about `frontend\models\Certificates`.
 */
class CertificatesSearch2 extends Certificates
{
    /**
     * @inheritdoc
     */
    // public $type;

    public $userName;
    public $companyName;


    public function rules()
    {
        return [
            // [['id', 'type_id', 'parent_id', 'modify_by'], 'integer'],
            // [['added', 'expire', 'valable', 'attachment', 'title', 'type', 'comments'], 'safe'],
            [['type_id', 'parent_id', 'title_en', 'title_fr', 'userName', 'companyName'], 'safe'],
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
        $query = Certificates::find()->where(['=', 'lic_certificates.account_id', $nAccountId]);

        // add conditions that should always apply here
        $query->joinWith([
            'type',
            'parent',
            'user',
            'company'
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
            'sort'       => [
                'defaultOrder' => [
                    'type_id'   => SORT_ASC,
                    'parent_id' => SORT_ASC,
                    // 'lic_certificates_types_items.title_'.Yii::$app->language=>SORT_ASC,
                ]
            ]
        ]);


        $dataProvider->sort->attributes['typeName'] = [
            'asc'  => ['lic_certificates_types_items.title_' . Yii::$app->language => SORT_ASC],
            'desc' => ['lic_certificates_types_items.title_' . Yii::$app->language => SORT_DESC],
        ];


        $dataProvider->sort->attributes['parent_id'] = [
            'asc'  => ['lic_certificates_types.title_' . Yii::$app->language => SORT_ASC],
            'desc' => ['lic_certificates_types.title_' . Yii::$app->language => SORT_DESC],
        ];


        $dataProvider->sort->attributes['userName'] = [
            'asc'  => ['lic_user.username' => SORT_ASC],
            'desc' => ['lic_user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['companyName'] = [
            'asc'  => ['lic_companies.title_' . Yii::$app->language => SORT_ASC],
            'desc' => ['lic_companies.title_' . Yii::$app->language => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'                         => $this->id,
            'type_id'                    => $this->type_id,
            'lic_certificates.parent_id' => $this->parent_id,
            'added'                      => $this->added,
            'expire'                     => $this->expire,
            'modify_by'                  => $this->modify_by,
            'lic_companies.id'           => $this->company_id,
            'comments'                   => $this->comments,
            // 'lic_certificates.title' => $this->title,
            // 'lic_certificates_types.title' => $this->type,
        ]);


        $query->andFilterWhere(['like', 'valable', $this->valable])
            // ->andFilterWhere(['like', 'lic_user.username', $this->userName])
            ->andFilterWhere(['like', 'lic_user.username', $this->userName])
            ->andFilterWhere(['like', 'lic_certificates.title_' . Yii::$app->language, $this->{'title_' . Yii::$app->language}])
            ->andFilterWhere(['like', 'lic_companies.title_' . Yii::$app->language, $this->companyName]);
        // ->andFilterWhere(['like', 'lic_certificates.title_en', $this->TypeName])
        // ->andFilterWhere(['like', 'lic_certificates.title_fr', $this->title_en])
        // ->andFilterWhere(['like', 'lic_certificates_types_items.title_en', $this->typeName])
        // ->andFilterWhere(['like', 'lic_certificates_types_items.title_fr', $this->typeName]);

        // var_dump($query);

        // $query->andFilterWhere(['or',
        //     ['like', 'type_id', $this->title_en],
        //     ['like', 'added', $this->title_en],
        //     ['like', 'expire', $this->title_en],
        //     ['like', 'modify_by', $this->title_en],
        //     ['like', 'comments', $this->title_en],
        //     ['like', 'valable', $this->title_en],
        //     ['like', 'lic_certificates.title_en', $this->title_en],
        //     ['like', 'lic_certificates.title_fr', $this->title_en],
        //     ['like', 'lic_certificates_types_items.title_en', $this->title_en],
        //     ['like', 'lic_certificates_types_items.title_fr', $this->title_en],
        //     ['like', 'lic_user.username', $this->title_en],
        // ]);

        return $dataProvider;
    }
}
