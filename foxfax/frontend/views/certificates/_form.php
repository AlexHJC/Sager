<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Certificates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="certificates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'type_id')->dropDownList($lic_types); ?>

    <?php //= $form->field($model, 'added')->textInput() ?>
    <?php /*
    <input class="form-control dp valid" autocomplete="off" type="text" name="db[3]" id="3" fieldid="ExpDate" value="24-11-2016" style="width:100px;" aria-invalid="false">
    */ ?>

    <?= $form->field($model, 'expire')->textInput(['class' => 'dp valid', ]) ?>
    
    <?=$form->field($model, 'valable')->dropDownList(Yii::$app->params['yes']); ?>
    
    <?= $form->field($model, 'attachment')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'modify_by')->textInput() ?>

    <?= $form->field($model, 'comments')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
