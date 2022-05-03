<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Periods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periods-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
		    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    	</div>
    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
		    <?= $form->field($model, 'days')->textInput() ?>
    	</div>
    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-3">
		    <?= $form->field($model, 'position')->textInput() ?>
    	</div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
