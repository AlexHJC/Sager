<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Products */

$this->title = Yii::t('form', 'Import Companies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($errors)){ ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Error</h4>
            <?php
                foreach($errors as $error) {
                    print_r($error);
                }
            ?>
        </div>
    <?php } ?>

    <div class="products-import-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="col-md-6">
            <?= $form->field($upload, 'csvFile')->fileInput()->label("Upload your csv file"); ?>
            <p class="help">
                The cs file should contain next columns:<br/>
                <strong>
                    <code>Title en</code>, <code>title fr</code>, <code>address</code>, <code>phone number</code>, <code>email</code>,
                   <code> description</code>, <code>sender name</code>, <code>sender email</code>, <code>alert email (0 or 1)</code>,
                    <code>alert sms (0 or 1)</code>, <code>alert defaul (0 or 1)</code>, <code>sms time</code>, <code>shared (0 or 1)</code>, <code>locale (en or fr)</code>, 
                     and delimiter can be <code>,</code>&nbsp;&nbsp; Example: <a href='<?=Yii::$app->request->baseUrl."/uploads/companies/companies_template.csv";?>' target='blank'><i class='fa fa-file-text fa-2x'></i> </a>
                </strong>
            </p>
        </div>
        <div class="col-md-6">
            <?=$form->field($model, 'country_id')->widget(Select2::classname(), [
                'data' => $countries,
                'language' => Yii::$app->language,
                'options' => [
                    // 'placeholder' => 'Select a state ...'
                ],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]);?>
        </div>
        <div class="form-group">
            <div class="col-md-12 text-right">
                <?= Html::submitButton(Yii::t('form', 'Upload'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
