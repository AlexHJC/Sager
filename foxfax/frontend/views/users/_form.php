<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserCreateForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form col-md-6">

    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'username') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group text-right" style="margin-top:30px">
        <?php echo Html::submitButton(Yii::t('frontend', 'Create new user'), ['class' => 'btn standard-button btn-success', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
