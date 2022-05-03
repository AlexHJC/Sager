<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Payments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'plan_id')->textInput() ?>

    <?= $form->field($model, 'payment_cycle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_amount')->textInput() ?>

    <?= $form->field($model, 'payment_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_country_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
