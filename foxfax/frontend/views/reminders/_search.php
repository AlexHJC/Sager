<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RemindersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reminders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'certificat_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'certificat_type') ?>

    <?php // echo $form->field($model, 'date_alert') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('form', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('form', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
