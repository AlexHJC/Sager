<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PaymentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'plan_id') ?>

    <?= $form->field($model, 'payment_cycle') ?>

    <?= $form->field($model, 'payer_id') ?>

    <?php // echo $form->field($model, 'payment_id') ?>

    <?php // echo $form->field($model, 'payment_state') ?>

    <?php // echo $form->field($model, 'payment_amount') ?>

    <?php // echo $form->field($model, 'payment_currency') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'invoice_number') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'payer_email') ?>

    <?php // echo $form->field($model, 'payer_first_name') ?>

    <?php // echo $form->field($model, 'payer_last_name') ?>

    <?php // echo $form->field($model, 'payer_phone') ?>

    <?php // echo $form->field($model, 'payer_country_code') ?>

    <?php // echo $form->field($model, 'plan_user_limit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
