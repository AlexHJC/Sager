<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NotificationsSearch represents the model behind the search form about `frontend\models\Notifications`.
 */
class NotificationsSearch extends Notifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'modified_by', 'position'], 'integer'],
            // [['title', 'subject', 'text', 'added', 'modified', 'status'], 'safe'],
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
        $query = Notifications::find();

        $query->joinWith([
            'user',
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

        $dataProvider->sort->attributes['userName'] = [
            'asc'  => ['lic_user.username' => SORT_ASC],
            'desc' => ['lic_user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $nAccountId = (!empty(Yii::$app->user->identity->parent_id)) ? Yii::$app->user->identity->parent_id : Yii::$app->user->identity->id;
        $query->andWhere(['=', 'lic_notifications.account_id', $nAccountId]);

        $query->andFilterWhere([
            'or',
            ['like', 'added', $this->title_en],
            ['like', 'modified', $this->title_en],
            ['like', 'position', $this->title_en],
            ['like', 'title_en', $this->title_en],
            ['like', 'title_fr', $this->title_en],
            ['like', 'subject_en', $this->title_en],
            ['like', 'subject_fr', $this->title_en],
            ['like', 'text_en', $this->title_en],
            ['like', 'text_fr', $this->title_en],
            ['like', 'modified_by', $this->title_en],
            ['like', 'lic_notifications.status', $this->title_en],
            ['like', 'lic_user.status', $this->title_en],
            ['like', 'lic_user.username', $this->title_en],
        ]);

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'added' => $this->added,
        //     'modified' => $this->modified,
        //     'modified_by' => $this->modified_by,
        //     'position' => $this->position,
        // ]);

        // $query->andFilterWhere(['like', 'title', $this->title])
        //     ->andFilterWhere(['like', 'subject', $this->subject])
        //     ->andFilterWhere(['like', 'text', $this->text])
        //     ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
