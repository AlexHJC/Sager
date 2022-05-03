<?php

namespace frontend\controllers;

use frontend\models\Alerts;
use frontend\models\AlertsSearch;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use frontend\models\Labels;
use frontend\models\Notifications;
use frontend\models\Periods;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * AlertsController implements the CRUD actions for Alerts model.
 */
class AlertsController extends BaseController
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
     * Lists all Alerts models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Alerts model.
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
     * Finds the Alerts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Alerts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alerts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Alerts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alerts();

        $maxPos = Alerts::find()
                ->leftJoin('{{%certificates}} cert', '`cert`.id = {{%alerts}}.certificat_id')
                ->where(['=', '`cert`.account_id', $this->nAccountId])
                ->select('position')->max('position') + 1;


        $certificates = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_en',
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title'];
                // return $cat->title;
            }
        );
        $labels = ArrayHelper::map(
            Labels::find()
                ->select(['id', 'title'])
                ->where(['=', 'account_id', $this->nAccountId])
                ->asArray()
                ->orderBy('position ASC')
                ->all(),
            'id', 'title'
        );

        $notifications = ArrayHelper::map(
            Notifications::find()
                ->select(['id', 'title_en'])
                ->where(['=', 'account_id', $this->nAccountId])
                ->asArray()
                ->orderBy('position ASC')
                ->all(),
            'id', 'title_en'
        );

        $periods = ArrayHelper::map(
            Periods::find()
                ->select(['id', 'title'])
                ->where(['=', 'account_id', $this->nAccountId])
                ->asArray()
                ->orderBy('position ASC')
                ->all(),
            'id', 'title'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'         => $model,
                'certificates'  => $certificates,
                'labels'        => $labels,
                'notifications' => $notifications,
                'periods'       => $periods,
                'maxPos'        => $maxPos,
            ]);
        }
    }

    /**
     * Updates an existing Alerts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $maxPos = $model->position;

        $certificates = ArrayHelper::map(
            CertificatesTypesItems::find()->select(['id', 'title_en', 'parent_id'])->asArray()
                ->where(['status' => 'active'])
                ->orderBy('position DESC')
                ->all(),
            'id', 'title_en',
            function ($modelo, $defaultValue) {
                $cat = CertificatesTypes::find()->where(['id' => $modelo['parent_id']])->one();
                return $cat['title'];
                // return $cat->title;
            }
        );

        $labels = ArrayHelper::map(
            Labels::find()
                ->select(['id', 'title'])
                ->where(['=', 'account_id', $this->nAccountId])
                ->asArray()
                ->orderBy('position ASC')
                ->all(),
            'id', 'title'
        );

        $notifications = ArrayHelper::map(
            Notifications::find()
                ->select(['id', 'title_en'])
                ->where(['=', 'account_id', $this->nAccountId])
                ->asArray()
                ->orderBy('position ASC')
                ->all(),
            'id', 'title_en'
        );

        $periods = ArrayHelper::map(
            Periods::find()
                ->select(['id', 'title'])
                ->where(['=', 'account_id', $this->nAccountId])
                ->asArray()
                ->orderBy('position ASC')
                ->all(),
            'id', 'title'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'         => $model,
                'certificates'  => $certificates,
                'labels'        => $labels,
                'notifications' => $notifications,
                'periods'       => $periods,
                'maxPos'        => $maxPos,
            ]);
        }
    }

    /**
     * Deletes an existing Alerts model.
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
}
