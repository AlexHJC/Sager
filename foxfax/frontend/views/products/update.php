<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Products */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Products');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Products',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="products-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'cod')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'title_en')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'title_fr')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <?php /*
            <div class="col-md-4">
                <?=$form->field($model, 'company_id')->dropDownList($companies); ?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'certificat_id')->dropDownList($certificates); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'lot')->textInput(['class' => 'form-control', ]) ?>
            </div>
            */ ?>

        </div>
        
                
               








	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
