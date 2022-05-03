<?php

namespace frontend\controllers;

use frontend\models\Alerts;
use frontend\models\Certificates;
use frontend\models\Certificates2;
use frontend\models\CertificatesAttach;
use frontend\models\CertificatesSearch;
use frontend\models\CertificatesSearch2;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use frontend\models\Companies;
use frontend\models\Periods;
use frontend\models\Products;
use frontend\models\Reminders;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * CertificatesController implements the CRUD actions for Certificates model.
 */
class CertificatesController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Certificates models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CertificatesSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex2()
    {
        $searchModel = new CertificatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index2', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionIndexcat($p_id)
    {
        $searchModel = new CertificatesSearch2();
        // $searchModel = new CertificatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andwhere('lic_certificates.type_id = ' . $p_id);
        // $dataProvider->query->andwhere('parent_id != 0');

        $type = CertificatesTypes::find()
            ->where(['id' => $p_id])
            ->one();

        return $this->render('indexcat', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'type'         => $type,
        ]);
    }

    /**
     * Displays a single Certificates model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {

        $attachments = CertificatesAttach::find()
            ->where(['certificat_id' => $id])
            ->orderBy('id')
            ->all();

        return $this->render('view', [
            'model'       => $this->findModel($id),
            'attachments' => $attachments
        ]);
    }

    /**
     * Finds the Certificates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Certificates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Certificates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Certificates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Certificates();

        $lic_types = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'title_fr', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_' . Yii::$app->language,
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title'];
                // return $cat->title;
            }
        );


        $products = ArrayHelper::map(
            Products::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr', 'cod'])->asArray()
                ->all(),
            'id',
            function ($modelo, $defaultValue) {
                return $modelo['cod'] . ' - ' . $modelo['title_' . Yii::$app->language];
            }
        );

        $suppliers = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id',
            function ($modelo, $defaultValue) {
                return $modelo['title_' . Yii::$app->language];
            }
        );


        if ($model->load(Yii::$app->request->post())) {

            $model->added = date('Y-m-d h:m:s');
            $model->modify_by = Yii::$app->user->identity->id;
            $model->account_id = $this->nAccountId;
            $le_type_item = CertificatesTypesItems::find()->where(['id' => $model->parent_id])->one();
            $model->type_id = $le_type_item['parent_id'];
            $model->attachment = '';


            if ($model->save()) {


                /*   *   *   *   *   Adaugare Reminders  *   *   *   *   *   * */

                $alerts = Alerts::find()
                    ->where(['certificat_id' => $model->parent_id])
                    ->orderBy('position ASC')
                    ->all();

                // var_dump(count($alerts));

                if (isset($alerts) && count($alerts) > 0) {
                    foreach ($alerts as $key => $alert) {
                        $new_alert[$key] = new Reminders();
                        $new_alert[$key]->certificat_id = $model->id;
                        $new_alert[$key]->product_id = $model->product_id;
                        $new_alert[$key]->company_id = $model->company_id;
                        $new_alert[$key]->certificat_type = $model->parent_id;
                        $new_alert[$key]->label_id = $alert->label_id;
                        $new_alert[$key]->alert_id = $alert->id;
                        $new_alert[$key]->notification_id = $alert->notification_id;
                        $new_alert[$key]->group = 'no';


                        $periods = Periods::findOne($alert->period_id);


                        if ($periods) {
                            // echo 'Alert+    '.$alert->period_id;
                            $expire_date = $model->expire;
                            $new_alert[$key]->expire = $expire_date;

                            $days = $periods['days'];
                            $new_alert[$key]->days = $days;

                            $notification_date = date('Y-m-d', strtotime($expire_date) + (24 * 3600 * $days));
                            // $notification_date = date('Y-m-d',strtotime($expire_date) + (24*3600*($days+1)));
                            $new_alert[$key]->date_alert = $notification_date;

                            $new_alert[$key]->status = 'active';
                            $new_alert[$key]->state = 'waiting';
                            $new_alert[$key]->save();
                            // var_dump($new_alert[$key]->errors);
                        }

                    }
                }

                /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * */

                /*   *   *   *   *  Adaugare attachments *   *   *   *   *   * */
                $new_un = Yii::$app->request->post('new_attach');
                if (isset($new_un) && is_array($new_un) && (count($new_un) > 0)) {
                    foreach ($new_un as $n => $n_un) {
                        if (isset($n_un['attach']) && ($n_un['attach'] != '')) {
                            $new_n[$n] = new CertificatesAttach();
                            $new_n[$n]->certificat_id = $model->id;
                            $new_n[$n]->file = $n_un['attach'];
                            $new_n[$n]->save();
                        }
                    }
                }
                /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * */

                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'       => $model,
                    'lic_types'   => $lic_types,
                    'products'    => $products,
                    'suppliers'   => $suppliers,
                    'attachments' => null,
                ]);
            }

        } else {
            return $this->render('update', [
                'model'       => $model,
                'lic_types'   => $lic_types,
                'products'    => $products,
                'suppliers'   => $suppliers,
                'attachments' => null,
            ]);
        }
    }

    /**
     * Updates an existing Certificates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */


    public function actionCreatemultimple()
    {

        $model = new Certificates2();

        $lic_types = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'title_fr', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_' . Yii::$app->language,
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title'];
                // return $cat->title;
            }
        );
        // $cert_types = CertificatesTypes::find()->with('itemsActive')->asArray()->orderBy('position ASC')->all();
        // foreach ($cert_types as $key => $value) {
        //     foreach ($value['itemsActive'] as $val)
        //     {
        //         $lic_types[$value['title_'.Yii::$app->language]][$val['id']] = $val['title_'.Yii::$app->language];
        //     }
        // }
        // print_r($cert_types); 
        // exit;
        $products = ArrayHelper::map(
            Products::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr', 'cod'])->asArray()
                ->all(),
            'id',
            function ($modelo, $defaultValue) {
                return $modelo['cod'] . ' - ' . $modelo['title_' . Yii::$app->language];
            }
        );

        $suppliers = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id',
            function ($modelo, $defaultValue) {
                return $modelo['title_' . Yii::$app->language];
            }
        );


        if ($model->load(Yii::$app->request->post())) {

            $model->added = date('Y-m-d h:m:s');
            $model->modify_by = Yii::$app->user->identity->id;
            $model->account_id = $this->nAccountId;
            $le_type_item = CertificatesTypesItems::find()->where(['id' => $model->parent_id])->one();
            $model->type_id = $le_type_item['parent_id'];
            $model->attachment = '';


            if ($model->validate()) {

                //$new_prodd = Yii::$app->request->post('new_prodd');
                $new_prodd = Yii::$app->request->post('product_id');
                
                $alerts = Alerts::find()
                    ->where(['certificat_id' => $model->parent_id])
                    ->orderBy('position ASC')
                    ->all();
                if (isset($new_prodd) && is_array($new_prodd) && (count($new_prodd) > 0)) {
                    foreach ($new_prodd as $t => $produs) {
                        // *   *   *   *   *   Adaugare Reminders  *   *   *   *   *   * * / 

                        $new_products[$t] = new Certificates();
                        $tempProd = new Product($produs);
                        $new_products[$t]->product_id = $tempProd['id'];
                        $new_products[$t]->title_en = $tempProd['title_en'];
                        $new_products[$t]->title_fr = $tempProd['title_fr'];
                        $new_products[$t]->company_id = $model->company_id;
                        $new_products[$t]->type_id = $model->type_id;
                        $new_products[$t]->added = $model->added;
                        $new_products[$t]->expire = $model->expire;
                        $new_products[$t]->valable = $model->valable;
                        $new_products[$t]->modify_by = $model->modify_by;
                        $new_products[$t]->account_id = $model->account_id;
                        $new_products[$t]->comments = $model->comments;
                        $new_products[$t]->parent_id = $model->parent_id;
                        $new_products[$t]->save();

                        //var_dump($produs);


                        if (isset($alerts) && count($alerts) > 0) {
                            foreach ($alerts as $key => $alert) {
                                $new_alert[$key] = new Reminders();
                                $new_alert[$key]->certificat_id = $new_products[$t]->id;
                                $new_alert[$key]->product_id = $model->product_id;
                                $new_alert[$key]->company_id = $model->company_id;
                                $new_alert[$key]->certificat_type = $model->parent_id;
                                $new_alert[$key]->label_id = $alert->label_id;
                                $new_alert[$key]->alert_id = $alert->id;
                                $new_alert[$key]->notification_id = $alert->notification_id;
                                $new_alert[$key]->group = 'yes';


                                $periods = Periods::findOne($alert->period_id);

                                if ($periods) {
                                    $expire_date = $model->expire;
                                    $new_alert[$key]->expire = $expire_date;

                                    $days = $periods['days'];
                                    $new_alert[$key]->days = $days;

                                    $notification_date = date('Y-m-d', strtotime($expire_date) + (24 * 3600 * $days));
                                    // $notification_date = date('Y-m-d',strtotime($expire_date) + (24*3600*($days+1)));
                                    $new_alert[$key]->date_alert = $notification_date;

                                    $new_alert[$key]->status = 'active';
                                    $new_alert[$key]->state = 'waiting';
                                    $new_alert[$key]->save();
                                }

                            }
                        }

                        // *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * * / 

                        // *   *   *   *   *  Adaugare attachments *   *   *   *   *   * * / 

                        $new_un = Yii::$app->request->post('new_attach');
                        if (isset($new_un) && is_array($new_un) && (count($new_un) > 0)) {
                            foreach ($new_un as $n => $n_un) {
                                if (isset($n_un['attach']) && ($n_un['attach'] != '')) {
                                    $new_n[$n] = new CertificatesAttach();
                                    $new_n[$n]->certificat_id = $new_products[$t]->id;
                                    $new_n[$n]->file = $n_un['attach'];
                                    $new_n[$n]->save();
                                }
                            }
                        }
                    }
                    // *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * * / 

                    return $this->redirect(['index', 'id' => $new_products[$t]->id]);

                } else {
                    return $this->render('createmultimple', [
                        'model'       => $model,
                        'lic_types'   => $lic_types,
                        'products'    => $products,
                        'suppliers'   => $suppliers,
                        'attachments' => null,
                    ]);
                }
            } else {
                return $this->render('createmultimple', [
                    'model'       => $model,
                    'lic_types'   => $lic_types,
                    'products'    => $products,
                    'suppliers'   => $suppliers,
                    'attachments' => null,
                ]);
            }

        } else {
            return $this->render('createmultimple', [
                'model'       => $model,
                'lic_types'   => $lic_types,
                'products'    => $products,
                'suppliers'   => $suppliers,
                'attachments' => null,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $lic_types = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'title_fr', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_' . Yii::$app->language,
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title'];
                // return $cat->title;
            }
        );

        $products = ArrayHelper::map(
            Products::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr', 'cod'])->asArray()
                ->all(),
            'id',
            function ($modelo, $defaultValue) {
                return $modelo['cod'] . ' - ' . $modelo['title_' . Yii::$app->language];
            }
        );

        $suppliers = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id',
            function ($modelo, $defaultValue) {
                return $modelo['title_' . Yii::$app->language];
            }
        );

        $attachments = CertificatesAttach::find()
            ->where(['certificat_id' => $id])
            ->orderBy('id')
            ->all();


        if ($model->load(Yii::$app->request->post())) {

            $model->modify_by = Yii::$app->user->identity->id;
            $model->account_id = $this->nAccountId;
            $le_type_item = CertificatesTypesItems::find()->where(['id' => $model->parent_id])->one();
            $model->type_id = $le_type_item['parent_id'];
            $model->attachment = '';

            // var_dump($le_type_item['title']);
            // echo '<br>SUbcat ID:<br>';
            // var_dump($model->parent_id);
            // echo '<br>Cat ID:<br>';
            // var_dump($le_type_item['parent_id']);
            // var_dump($model->parent_id);
            // var_dump($model->type_id);
            // var_dump($le_type_item);


            if ($model->save()) {


                /*   *   *   *   *   Stergere Reminders  *   *   *   *   *   * */

                Reminders::deleteAll('certificat_id = :certificat_id AND state = :state', [':certificat_id' => $model->id, ':state' => 'waiting']);


                /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * */

                /*   *   *   *   *   Adaugare Reminders  *   *   *   *   *   * */

                $alerts = Alerts::find()
                    ->where(['certificat_id' => $model->parent_id])
                    ->orderBy('position ASC')
                    ->all();

                // echo 'Parent ID'.$model->parent_id;


                if (isset($alerts) && count($alerts) > 0) {
                    foreach ($alerts as $key => $alert) {

                        // echo 'Repetare';

                        $new_alert[$key] = new Reminders();
                        $new_alert[$key]->certificat_id = $model->id;
                        $new_alert[$key]->product_id = $model->product_id;
                        $new_alert[$key]->company_id = $model->company_id;
                        $new_alert[$key]->certificat_type = $model->parent_id;
                        $new_alert[$key]->label_id = $alert->label_id;
                        $new_alert[$key]->alert_id = $alert->id;
                        $new_alert[$key]->notification_id = $alert->notification_id;

                        $periods = Periods::findOne($alert->period_id);

                        if ($periods) {
                            $expire_date = $model->expire;
                            $new_alert[$key]->expire = $expire_date;

                            $days = $periods['days'];
                            $new_alert[$key]->days = $days;

                            $notification_date = date('Y-m-d', strtotime($expire_date) + (24 * 3600 * $days));
                            // $notification_date = date('Y-m-d',strtotime($expire_date) + (24*3600*($days+1)));
                            $new_alert[$key]->date_alert = $notification_date;

                            $new_alert[$key]->status = 'active';
                            $new_alert[$key]->state = 'waiting';
                            $new_alert[$key]->save();
                        }

                    }
                }

                /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * */

                /*   *   *   *   *  Adaugare attachments *   *   *   *   *   * */
                $new_un = Yii::$app->request->post('new_attach');
                if (isset($new_un) && is_array($new_un) && (count($new_un) > 0)) {
                    foreach ($new_un as $n => $n_un) {
                        if (isset($n_un['attach']) && ($n_un['attach'] != '')) {
                            $new_n[$n] = new CertificatesAttach();
                            $new_n[$n]->certificat_id = $model->id;
                            $new_n[$n]->file = $n_un['attach'];
                            $new_n[$n]->save();
                        }
                    }
                }
                /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * */

                /*   *   *   *   *  Remove attachments *   *   *   *   *   * */
                $del_un = Yii::$app->request->post('remove_attach');
                if (isset($del_un) && is_array($del_un) && (count($del_un) > 0)) {
                    foreach ($del_un as $n => $n_un) {
                        if (isset($n_un) && ($n_un != '')) {
                            CertificatesAttach::findOne($n_un)->delete();
                        }
                    }
                }
                /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   * */
                // echo 'return';
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'       => $model,
                    'lic_types'   => $lic_types,
                    'attachments' => $attachments,
                    'products'    => $products,
                    'suppliers'   => $suppliers,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'       => $model,
                'lic_types'   => $lic_types,
                'attachments' => $attachments,
                'products'    => $products,
                'suppliers'   => $suppliers,
            ]);
        }
    }

    public function actionGetprod($id)
    {
        if (substr_count($id, ',') > 0) {
            $ids = explode(',', $id);
        } else $ids = [$id];
        $prod = Products::find()->where(['in', 'id', $ids])->all();
        $response = [];
        foreach ($prod as $value) {
            $response[] = [
                'id' => $value->id,
                'title_en' => $value->title_en,
                'title_fr' => $value->title_fr
            ];
        }

        return json_encode($response);
    }

    /**
     * Deletes an existing Certificates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */


    public function actionDelete($id)
    {

        Reminders::deleteAll(['certificat_id' => $id]);
        CertificatesAttach::deleteAll(['certificat_id' => $id]);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
