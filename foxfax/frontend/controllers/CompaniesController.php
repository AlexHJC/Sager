<?php

namespace frontend\controllers;

use frontend\models\Certificates;
use frontend\models\CertificatesSearch2;
use frontend\models\Companies;
use frontend\models\CompaniesSearch;
use frontend\models\CompaniesUpload;
use frontend\models\Countries;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompaniesController extends BaseController
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
     * Lists all Companies models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompaniesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Companies model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {

        $searchModel = new CertificatesSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(array('company_id' => $id));

        $certificates = Certificates::find()
            ->where(['company_id' => $id])
            ->orderBy('id')
            ->all();


        return $this->render('view', [
            'model'        => $this->findModel($id),
            'certificates' => $certificates,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Companies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Companies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Companies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Companies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Companies();

        $countries = ArrayHelper::map(
            Countries::find()
                ->select(['id', 'title_en'])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );


        if ($model->load(Yii::$app->request->post())) {
            $model->date_added = date('Y-m-d h:m:s');
            $model->account_id = $this->nAccountId;

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'     => $model,
                    'countries' => $countries,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'     => $model,
                'countries' => $countries,
            ]);
        }
    }

    public function actionImport()
    {
        $oModel = new Companies();
        $oUploadModel = new CompaniesUpload();
        $aErrors = array();

        $countries = ArrayHelper::map(
            Countries::find()
                ->select(['id', 'title_en'])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );


        if (Yii::$app->request->isPost) {

            $nCountryId = $_POST['Companies']['country_id'];
            if (!empty($nCountryId)) {
                $oUploadModel->csvFile = UploadedFile::getInstance($oUploadModel, 'csvFile');
                if ($oUploadModel->upload()) {
                    try {
                        $inputFileType = $oUploadModel->getUploadedFilePath();
                        $objPHPExcel = \PHPExcel_IOFactory::load($inputFileType);

                        $sheet = $objPHPExcel->getSheet(0);
                        $highestRow = $sheet->getHighestRow();
                        $highestColumn = $sheet->getHighestColumn();
                        $nrColumns = ord($highestColumn) - 64;

                        if (strtolower($highestColumn) == 'n') {
                            for ($row = 1; $row <= $highestRow; $row++) {
                                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                                $aValuesRow = $rowData[0];
                                $aValues[] = array(
                                    $aValuesRow[0],
                                    $aValuesRow[1],
                                    $aValuesRow[2],
                                    $aValuesRow[3],
                                    $aValuesRow[4],
                                    $this->nAccountId,
                                    $aValuesRow[5],
                                    $aValuesRow[6],
                                    $aValuesRow[7],
                                    $aValuesRow[8],
                                    $aValuesRow[9],
                                    $aValuesRow[10],
                                    $nCountryId,
                                    $aValuesRow[11],
                                    $aValuesRow[12],
                                );

                            }

                            $sTable = $oModel->tableName();
                            $aColumns = array(
                                'title_en', 'title_fr', 'adress', 'phone', 'email', 'account_id', 'description',
                                'sender_name', 'sender_email', 'alert_email', 'alert_sms', 'alert_default',
                                'country_id', 'shared', 'locale'
                            );

                            $insertCount = Yii::$app->db->createCommand()
                                ->batchInsert(
                                    $sTable, $aColumns, $aValues
                                )
                                ->execute();

                            if ($insertCount) {
                                redirect(Yii::$app->urlManager->createAbsoluteUrl('companies/index'));
                            }
                        } else {
                            $aErrors[] = "Please check your file structure and try again.";
                        }

                    }
                    catch (\PHPExcel_Exception $e) {
                        $aErrors[] = $e->getMessage();
                    }

                } else {
                    $aErrors = $oUploadModel->getErrors('csvFile');
                }
            } else {
                $aErrors[] = "Please choose a country.";
            }
        }

        return $this->render('import', [
            'upload'    => $oUploadModel,
            'model'     => $oModel,
            'countries' => $countries,
            'errors'    => $aErrors,
        ]);
    }

    /**
     * Updates an existing Companies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $countries = ArrayHelper::map(
            Countries::find()
                ->select(['id', 'title_en'])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );

        if ($model->load(Yii::$app->request->post())) {
            $model->last_modify = date('Y-m-d h:m:s');
            $model->account_id = $this->nAccountId;
            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model'     => $model,
                    'countries' => $countries,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'     => $model,
                'countries' => $countries,
            ]);
        }
    }

    /**
     * Deletes an existing Companies model.
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
