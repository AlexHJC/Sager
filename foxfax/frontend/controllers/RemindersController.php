<?php

namespace frontend\controllers;

use frontend\models\Alerts;
use frontend\models\Certificates;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use frontend\models\Companies;
use frontend\models\Labels;
use frontend\models\Notifications;
use frontend\models\Products;
use frontend\models\Reminders;
use frontend\models\RemindersSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;


/**
 * RemindersController implements the CRUD actions for Reminders model.
 */
class RemindersController extends BaseController
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
     * Lists all Reminders models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RemindersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionWaiting()
    {
        $searchModel = new RemindersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['state' => 'waiting']);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionSended()
    {
        $searchModel = new RemindersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['state' => 'sent']);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Reminders model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Reminders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Reminders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reminders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Reminders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reminders();

        $certificates = ArrayHelper::map(
            Certificates::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $products = ArrayHelper::map(
            Products::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $companies = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $labels = ArrayHelper::map(
            Labels::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title', 'color'])->asArray()
                ->all(),
            'id', 'title'
        );

        $alerts = ArrayHelper::map(
            Alerts::find()
                ->leftJoin('lic_certificates', 'lic_certificates.id = lic_alerts.certificat_id')
                ->where(['=', 'lic_certificates.account_id', $this->nAccountId])
                ->select(['lic_alerts.id', 'certificat_id'])->asArray()
                ->all(),
            'id', function ($modelo, $defaultValue) {
            return 'Certificat #' . $modelo['certificat_id'];
        }
        );

        $notifications = ArrayHelper::map(
            Notifications::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );


        $lic_types = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'title_fr', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_en',
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title_' . Yii::$app->language];
                // return $cat->title;
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'         => $model,
                'certificates'  => $certificates,
                'products'      => $products,
                'companies'     => $companies,
                'lic_types'     => $lic_types,
                'labels'        => $labels,
                'alerts'        => $alerts,
                'notifications' => $notifications,
            ]);
        }
    }

    /**
     * Updates an existing Reminders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $certificates = ArrayHelper::map(
            Certificates::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $products = ArrayHelper::map(
            Products::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $companies = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $lic_types = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'title_fr', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_en',
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title_' . Yii::$app->language];
                // return $cat->title;
            }
        );

        $alerts = ArrayHelper::map(
            Alerts::find()
                ->leftJoin('{{%certificates}} `cert`', '`cert`.id = {{%alerts}}.certificat_id')
                ->where(['=', '`cert`.account_id', $this->nAccountId])
                ->select(['{{%alerts}}.id', '{{%alerts}}.certificat_id'])->asArray()
                ->all(),
            'id', function ($modelo, $defaultValue) {
            return 'Certificat #' . $modelo['certificat_id'];
        }
        );

        $notifications = ArrayHelper::map(
            Notifications::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en', 'title_fr'])->asArray()
                ->all(),
            'id', 'title_' . Yii::$app->language
        );

        $labels = ArrayHelper::map(
            Labels::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title', 'color'])->asArray()
                ->all(),
            'id', 'title'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'         => $model,
                'certificates'  => $certificates,
                'products'      => $products,
                'companies'     => $companies,
                'lic_types'     => $lic_types,
                'labels'        => $labels,
                'alerts'        => $alerts,
                'notifications' => $notifications,
            ]);
        }
    }

    /**
     * Deletes an existing Reminders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionResend($id)
    {

        $this->layout = "emptylayout";

        return $this->render('resend', [
            'id'   => $id,
            'bulk' => false,
        ]);

    }

    public function actionBulkResend()
    {
        $this->layout = "emptylayout";
        $aParam = Yii::$app->request->post('keys');
        if (!empty($aParam) && is_array($aParam)) {
            foreach ($aParam as $id) {
                $aNotice[] = $this->render('resend', ['id' => $id, 'bulk' => true]);
            }

            echo json_encode($aNotice);
        }
    }
}
