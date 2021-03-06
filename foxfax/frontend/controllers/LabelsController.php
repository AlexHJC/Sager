<?php

namespace frontend\controllers;

use frontend\models\Labels;
use frontend\models\LabelsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * LabelsController implements the CRUD actions for Labels model.
 */
class LabelsController extends BaseController
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
     * Lists all Labels models.
     *
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $searchModel = new LabelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $maxPos = Labels::find()->select('position')->max('position') + 1;

        if (isset($id) && ($id != null)) {
            $model = $this->findModel($id);
        } else {
            $model = new Labels();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->account_id = $this->nAccountId;
            if ( $model->save()) {
                Yii::$app->session->setFlash('success', "Changes saved successfully");
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }

        return $this->render('index', [
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'maxPos'       => $maxPos,
        ]);
    }

    /**
     * Finds the Labels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Labels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Labels::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Labels model.
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
     * Creates a new Labels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Labels();

        $maxPos = Labels::find()->select('position')->max('position') + 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model'  => $model,
                'maxPos' => $maxPos,
            ]);
        }
    }

    /**
     * Updates an existing Labels model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'  => $model,
                'maxPos' => $maxPos,
            ]);
        }
    }

    /**
     * Deletes an existing Labels model.
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
