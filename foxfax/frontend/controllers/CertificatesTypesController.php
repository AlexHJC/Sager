<?php

namespace frontend\controllers;

use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use frontend\models\CertificatesTypesSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * CertificatesTypesController implements the CRUD actions for CertificatesTypes model.
 */
class CertificatesTypesController extends BaseController
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
     * Lists all CertificatesTypes models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CertificatesTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CertificatesTypes model.
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
     * Finds the CertificatesTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return CertificatesTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CertificatesTypes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new CertificatesTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CertificatesTypes();

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

        $parent_cat = $parent_cat;

        $maxPos = CertificatesTypes::find()->select('position')->max('position') + 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $maxPos = CertificatesTypesItems::find()->select('position')->max('position') + 1;

            $default_subcat = new CertificatesTypesItems();
            $default_subcat->parent_id = $model->id;
            $default_subcat->title_en = 'Default';
            $default_subcat->title_fr = 'Défaut';
            $default_subcat->status = 'active';
            $default_subcat->position = $maxPos;
            $default_subcat->save();


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
     * Updates an existing CertificatesTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $parent_cat = ArrayHelper::map(
            CertificatesTypes::find()
                ->select(['id', 'title_en'])
                ->where(['status' => 'active'])
                ->andwhere(['<>', 'id', $model->id])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );
        // $p_arr = array(0 => "Parent Category");
        // $parent_cat = $p_arr + $parent_cat;

        $parent_cat = $parent_cat;

        $maxPos = $model->position;

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
     * Deletes an existing CertificatesTypes model.
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
