<?php

namespace frontend\controllers;

use frontend\models\Notifications;
use frontend\models\NotificationsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends BaseController
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
     * Lists all Notifications models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notifications model.
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
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Notifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Notifications();

        $maxPos = Notifications::find()->where(['=', 'account_id', $this->nAccountId])->select('position')->max('position') + 1;

        if ($model->load(Yii::$app->request->post())) {
            $model->added = date('Y-m-d h:m:s');
            $model->modified = date('Y-m-d h:m:s');
            $model->modified_by = Yii::$app->user->identity->id;
            $model->account_id = $this->nAccountId;

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'  => $model,
                    'maxPos' => $maxPos,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'  => $model,
                'maxPos' => $maxPos,
            ]);
        }
    }

    /**
     * Updates an existing Notifications model.
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

        if ($model->load(Yii::$app->request->post())) {
            $model->modified = date('Y-m-d h:m:s');
            $model->modified_by = Yii::$app->user->identity->id;
            $model->account_id = $this->nAccountId;
            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'  => $model,
                    'maxPos' => $maxPos,
                ]);
            }

        } else {
            return $this->render('update', [
                'model'  => $model,
                'maxPos' => $maxPos,
            ]);
        }
    }

    /**
     * Deletes an existing Notifications model.
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
