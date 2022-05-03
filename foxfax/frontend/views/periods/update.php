<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Periods */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Periods');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Periods',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Periods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="periods-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="periods-form">

	    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
		    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
			    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	    	</div>
	    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
			    <?= $form->field($model, 'days')->textInput() ?>
	    	</div>
            <div class="col-md-4">
                <?= $form->field($model, 'position')->textInput(['value' => $maxPos, 'class' => 'form-control', ]) ?>
            </div>
	    </div>


	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
