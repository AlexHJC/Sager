<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Labels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="widget">

    <?php $form = ActiveForm::begin(); ?>

        <div class="widget-header">
            <h3><i class="fa <?=($model->isNewRecord)?'fa-plus':'fa-pencil-square-o';?>"></i> <?=($model->isNewRecord)?'Add Status':'Edit Status: '.$model->title;?> </h3>
            <div class="btn-group widget-header-toolbar"> 
			        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn01' : 'btn btn-primary btn01']) ?>
                    <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn btn01']) ?>
            </div>
        </div>
        <div class="widget-content widget01">
        	<div class="row">
        		<div class="col-sm-4">
		    		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        		</div>
        		<div class="col-sm-2">
		    		<?= $form->field($model, 'color')->textInput(['maxlength' => true, 'class'=>'color form-control color_picker']) ?>
        		</div>
        		<div class="col-sm-3">
					<?=$form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?>
        		</div>
        		<div class="col-sm-3">
                    <?= $form->field($model, 'position')->textInput(['value' => ($model->isNewRecord)?$maxPos:$model->position, 'class' => 'form-control', ]) ?>
        		</div>
        	</div>
		</div>


    <?php ActiveForm::end(); ?>

</div>


