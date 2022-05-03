<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use kartik\select2\Select2;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model frontend\models\Reminders */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Reminders');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Reminders',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Reminders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="reminders-update">

    <h1><?= Html::encode($this->title) ?></h1>





	<div class="reminders-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
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
                <?=$form->field($model, 'product_id')->widget(Select2::classname(), [
                    'data' => $products,
                    'language' => Yii::$app->language,
                    'options' => [
                        // 'placeholder' => 'Select a state ...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
                <?=$form->field($model, 'company_id')->widget(Select2::classname(), [
                    'data' => $companies,
                    'language' => Yii::$app->language,
                    'options' => [
                        // 'placeholder' => 'Select a state ...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
                <?= $form->field($model, 'days')->textInput(['class' => 'form-control', ]) ?>
            </div>
            <div class="col-md-4">
            
                <?=$form->field($model, 'certificat_type')->widget(Select2::classname(), [
                    'data' => $lic_types,
                    'language' => Yii::$app->language,
                    'options' => [
                        // 'placeholder' => 'Select a state ...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
                <?= $form->field($model, 'date_alert')->textInput(['class' => 'dp form-control', ]) ?>
                <?=$form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?>
                <?= $form->field($model, 'expire')->textInput(['class' => 'dp form-control', ]) ?>
            </div>
            <div class="col-md-4">
				<?=$form->field($model, 'state')->dropDownList(Yii::$app->params['state']); ?>
    			<?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>
                
                <?=$form->field($model, 'label_id')->widget(Select2::classname(), [
                    'data' => $labels,
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
        <div class="row">    
            <div class="col-md-4">
                <?=$form->field($model, 'alert_id')->widget(Select2::classname(), [
                    'data' => $alerts,
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
                <?=$form->field($model, 'notification_id')->widget(Select2::classname(), [
                    'data' => $notifications,
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
                <?=$form->field($model, 'group')->dropDownList(Yii::$app->params['yes']); ?>
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
