<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use kartik\select2\Select2;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Certificates */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Certificates Types Items');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Certificates Types Items',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Certificates Types Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="certificates-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="certificates-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title_en')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'title_fr')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'position')->textInput(['value' => $maxPos, 'class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-6">
                <?=$form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?>
            </div>
            
	        <div class="col-md-6">
	            <?=$form->field($model, 'parent_id')->widget(Select2::classname(), [
	                'data' => $parent_cat,
	                'language' => Yii::$app->language,
	                'options' => [
	                    // 'placeholder' => 'Select a state ...'
	                    ],
	                'pluginOptions' => [
	                    'allowClear' => false
	                ],
	            ]);?>
	        </div>
        </div>


	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>

