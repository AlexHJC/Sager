<?php

namespace frontend\controllers;

use frontend\models\Certificates;
use frontend\models\Companies;
use frontend\models\Products;
use frontend\models\ProductsSearch;
use frontend\models\ProductsUpload;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends BaseController
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
     * Lists all Products models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {


        $certificates = Certificates::find()
            ->where(['product_id' => $id, 'account_id' => $this->nAccountId])
            ->orderBy('id')
            ->all();

        return $this->render('view', [
            'model'        => $this->findModel($id),
            'certificates' => $certificates,
        ]);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        $companies = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en'])->asArray()
                ->all(),
            'id', 'title_en');
        $certificates = ArrayHelper::map(
            Certificates::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en'])->asArray()
                ->where(['valable' => 'yes'])
                ->all(),
            'id', 'title_en');


        $model->account_id = $this->nAccountId;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'        => $model,
                'companies'    => $companies,
                'certificates' => $certificates,
            ]);
        }
    }

    public function actionImport()
    {
        $oModel = new Products();
        $oUploadModel = new ProductsUpload();
        $aErrors = array();

        if (Yii::$app->request->isPost) {
            $oUploadModel->csvFile = UploadedFile::getInstance($oUploadModel, 'csvFile');

            if ($oUploadModel->upload()) {
                try {
                    $inputFileType = $oUploadModel->getUploadedFilePath();
                    $objPHPExcel = \PHPExcel_IOFactory::load($inputFileType);

                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    if ($highestColumn == 'C') {
                        for ($row = 1; $row <= $highestRow; $row++) {
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                            $aValuesRow = $rowData[0];
                            $aValues[] = array(
                                $aValuesRow[0],
                                $aValuesRow[1],
                                $aValuesRow[2],
                                $this->nAccountId,
                            );

                        }

                        $sTable = $oModel->tableName();
                        $aColumns = array(
                            'cod', 'title_en', 'title_fr', 'account_id'
                        );

                        $insertCount = Yii::$app->db->createCommand()
                            ->batchInsert(
                                $sTable, $aColumns, $aValues
                            )
                            ->execute();

                        if ($insertCount) {
                            redirect(Yii::$app->urlManager->createAbsoluteUrl('products/index'));
                        }
                    } else {
                        $aErrors[] = "Please check your file structure, you should have 3 columns in it: cod, title_en, title_fr";
                    }

                }
                catch (\PHPExcel_Exception $e) {
                    $aErrors[] = $e->getMessage();
                }

            } else {
                $aErrors = $oUploadModel->getErrors('csvFile');
            }
        }

        return $this->render('import', [
            'upload' => $oUploadModel,
            'errors' => $aErrors,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $companies = ArrayHelper::map(
            Companies::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en'])->asArray()
                ->all(),
            'id', 'title_en');
        $certificates = ArrayHelper::map(
            Certificates::find()->where(['=', 'account_id', $this->nAccountId])->select(['id', 'title_en'])->asArray()
                ->where(['valable' => 'yes'])
                ->all(),
            'id', 'title_en');

        $model->account_id = $this->nAccountId;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'        => $model,
                'companies'    => $companies,
                'certificates' => $certificates,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
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
