<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Companies */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Companies');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Companies',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="companies-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="companies-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'title_en')->textInput(['class' => 'form-control', ]) ?>
                <?= $form->field($model, 'title_fr')->textInput(['class' => 'form-control', ]) ?>
			    <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>
			    <?php /*
			    	<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
			    */ ?>
			    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
				    'mask' => '(999)-999-9999',
				]) ?>

			    <?= $form->field($model, 'shared')->checkbox(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
    			<?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>
			    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			    <?= $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>
			    <?php //= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>
			    <?= $form->field($model, 'alert_email')->checkbox(['maxlength' => true]) ?>
			    <?= $form->field($model, 'alert_sms')->checkbox(['maxlength' => true]) ?>
			    <?= $form->field($model, 'alert_default')->checkbox(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?php //=$form->field($model, 'country_id')->dropDownList($countries); ?>
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

    			<?= $form->field($model, 'description')->textarea(['rows' => 7]) ?>
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
