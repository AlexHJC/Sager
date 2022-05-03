<?php

namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\UserCreateForm;
use frontend\models\UsersSearch;
use frontend\models\UserUpdateForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends BaseController
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
     * Lists all Users models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $aUsers = $this->getNumberOfRemainUsers();
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'aUsers'       => $aUsers,
        ]);
    }

    /**
     * Displays a single Users model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        if ($this->bIsAccount && is_numeric($id)) {
            $model = $this->findModel($id);
        } else {
            $model = null;
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $aUsers = $this->getNumberOfRemainUsers();

        if (empty($aUsers['nRemain'])) {
            Yii::$app->getSession()->setFlash('error', 'Your subscription plan is out of limits. Please upgrade to continue');
            redirect(Yii::$app->urlManager->createAbsoluteUrl('users/index'));
        }

        $model = new UserCreateForm();
        $aResult = array('type' => 'error', 'msg' => 'Something went wrong please try again.');
        if ($this->bIsAccount && $model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user) {
                $aResult['type'] = "success";
                $msg = "New user account has been successfully created.";
                if (!empty($model->send_email)) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body'    => Yii::t(
                            'frontend',
                            'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'options' => ['class' => 'alert-success']
                    ]);
                    $msg .= " An email has been sent with activation details.";
                }

                $aResult['msg'] = $msg;

                Yii::$app->getSession()->setFlash($aResult['type'], $aResult['msg']);
                redirect(Yii::$app->urlManager->createAbsoluteUrl('users/index'));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if ($this->bIsAccount && is_numeric($id)) {
            $user = Users::findOne($id);
            if ($user) {
                $oUserModel = new UserUpdateForm();
                $oUserModel->setModel($user);

                if ($oUserModel->load(Yii::$app->request->post()) && $oUserModel->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Users account has been updated sucxcessfully.');
                    redirect(Yii::$app->urlManager->createAbsoluteUrl('users/index'));
                }
            }
        }

        return $this->render('update', [
            'model' => $oUserModel,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->bIsAccount && is_numeric($id)) {
            $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

}
