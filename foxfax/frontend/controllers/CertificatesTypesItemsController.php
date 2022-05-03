<?php

namespace frontend\controllers;

use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use frontend\models\CertificatesTypesItemsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * CertificatesTypesItemsController implements the CRUD actions for CertificatesTypesItems model.
 */
class CertificatesTypesItemsController extends BaseController
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
     * Lists all CertificatesTypesItems models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CertificatesTypesItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CertificatesTypesItems model.
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
     * Finds the CertificatesTypesItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return CertificatesTypesItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CertificatesTypesItems::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new CertificatesTypesItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CertificatesTypesItems();

        $maxPos = CertificatesTypesItems::find()->select('position')->max('position') + 1;

        $parent_cat = ArrayHelper::map(
            CertificatesTypes::find()
                ->select(['id', 'title_en'])
                ->where(['status' => 'active'])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );
        // $p_arr = array(0 => "Parent Category");
        // $parent_cat = $p_arr + $parent_cat;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'      => $model,
                'parent_cat' => $parent_cat,
                'maxPos'     => $maxPos,
            ]);
        }
    }

    /**
     * Updates an existing CertificatesTypesItems model.
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

        $parent_cat = ArrayHelper::map(
            CertificatesTypes::find()
                ->select(['id', 'title_en'])
                ->where(['status' => 'active'])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );
        // $p_arr = array(0 => "Parent Category");
        // $parent_cat = $p_arr + $parent_cat;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'      => $model,
                'parent_cat' => $parent_cat,
                'maxPos'     => $maxPos,
            ]);
        }
    }

    /**
     * Deletes an existing CertificatesTypesItems model.
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
