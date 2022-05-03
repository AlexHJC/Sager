<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Products */

$this->title = Yii::t('form', 'Import Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Products'), 'url' => ['index']];
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
                    //echo "<p>" . $error . "</p>";
                }
            ?>
        </div>
    <?php } ?>

    <div class="products-import-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($upload, 'csvFile')->fileInput()->label("Upload your csv file in format of 3 columns (<code>cod</code>,<code>title en</code>, <code>title fr</code>) and delimiter can be <code>,</code>&nbsp;&nbsp; Example: <a href='".Yii::$app->request->baseUrl."/uploads/products/products_template.csv"."' target='blank'><i class='fa fa-file-text fa-2x'></i> </a>"); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('form', 'Upload'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
