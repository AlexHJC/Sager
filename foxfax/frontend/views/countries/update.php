<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Countries */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Countries');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Countries',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="countries-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="countries-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'code')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'title_en')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'title_fr')->textInput(['class' => 'form-control', ]) ?>
            </div>
           
            

            
            
            <?php /*

			sms_time time

            */ ?>

        </div>
        
                
               


	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
