<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Alerts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'certificat_id')->textInput() ?>

    <?= $form->field($model, 'label_id')->textInput() ?>

    <?= $form->field($model, 'notification_id')->textInput() ?>

    <?= $form->field($model, 'period_id')->textInput() ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
