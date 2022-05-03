<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Notifications */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Notifications');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Notifications',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="notifications-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="notifications-form">

	    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
		    <div class="col-md-6">
                <?= $form->field($model, 'title_en')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'title_fr')->textInput(['class' => 'form-control', ]) ?>
            </div>
	        <div class="col-md-6">
                <?= $form->field($model, 'subject_en')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'subject_fr')->textInput(['class' => 'form-control', ]) ?>
            </div>
	        <div class="col-md-6">
                <?=$form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'position')->textInput(['value' => $maxPos, 'class' => 'form-control', ]) ?>
            </div>
	    </div>

        <div class="row">
            <div class="col-md-12">
                <h4>Regular expresion in SUBJECT and EMAIL TEXT:</h4>
            </div>
            <div class="col-md-6">
                <strong>{id}</strong> - Certificat ID<br>
                <strong>{certificatName}</strong> - Certificat Name<br>
                <strong>{dateExpire}</strong> - Expire date<br>
                <br>
            </div>
            <div class="col-md-6">
                <strong>{daysLeft}</strong> - Days Left<br>
                <strong>{company}</strong> - Company Name<br>
                <br>
            </div>
        </div>
	    <div class="row">
            <div class="col-md-12">
                <?php echo $form->field($model, 'text_en')->widget(
                    \yii\imperavi\Widget::className(),
                    [
                        'plugins' => [
                            'fullscreen', 'fontcolor', 'video', 'advanced', 'format', 'bold', 'italic', 
                            'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule',
                            'bufferbuttons', 'scriptbuttons',
                            ],
                        'options'=>[
                            'minHeight'=>400,
                            'maxHeight'=>400,
                            'buttonSource'=>true,
                            'imageUpload'=>Yii::$app->urlManager->createUrl(['file-storage/upload-imperavi']),
                            // 'lang' => 'en',
                        ],
                    ]
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->field($model, 'text_fr')->widget(
                    \yii\imperavi\Widget::className(),
                    [
                        'plugins' => [
                            'fullscreen', 'fontcolor', 'video', 'advanced', 'format', 'bold', 'italic', 
                            'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule',
                            'bufferbuttons', 'scriptbuttons',
                            ],
                        'options'=>[
                            'minHeight'=>400,
                            'maxHeight'=>400,
                            'buttonSource'=>true,
                            'imageUpload'=>Yii::$app->urlManager->createUrl(['file-storage/upload-imperavi']),
                            // 'lang' => 'en',
                        ],
                    ]
                ) ?>
            </div>
        </div>




	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
