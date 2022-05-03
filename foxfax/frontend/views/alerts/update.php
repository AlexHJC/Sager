<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use kartik\select2\Select2;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Alerts */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Alerts');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Alerts',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Alerts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="alerts-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="alerts-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?php //=$form->field($model, 'certificat_id')->dropDownList($certificates); ?>
                <?=$form->field($model, 'certificat_id')->widget(Select2::classname(), [
                    'data' => $certificates,
                    'language' => Yii::$app->language,
                    'options' => [
                        // 'placeholder' => 'Select a state ...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'label_id')->dropDownList($labels); ?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'notification_id')->dropDownList($notifications); ?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'period_id')->dropDownList($periods); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'position')->textInput(['value' => $maxPos, 'class' => 'form-control', ]) ?>
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
