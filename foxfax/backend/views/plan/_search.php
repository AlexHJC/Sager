<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PlanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'plan_slug') ?>

    <?= $form->field($model, 'plan_title') ?>

    <?= $form->field($model, 'plan_price_year') ?>

    <?= $form->field($model, 'plan_price_month') ?>

    <?php // echo $form->field($model, 'plan_doc_limit') ?>

    <?php // echo $form->field($model, 'plan_user_limit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
