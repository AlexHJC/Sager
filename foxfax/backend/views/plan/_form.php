<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Plan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'plan_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_price_year')->textInput() ?>

    <?= $form->field($model, 'plan_price_month')->textInput() ?>

    <?= $form->field($model, 'plan_doc_limit')->textInput() ?>

    <?= $form->field($model, 'plan_user_limit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
