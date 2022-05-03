<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Users Settings')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-2">
            <?php echo $form->field($model->getModel('profile'), 'picture')->widget(
                Upload::classname(),
                [
                    'url' => ['avatar-upload']
                ]
            )?> 
        </div>
        <div class="col-md-3">
            <h4><?php echo Yii::t('frontend', 'Profile settings') ?></h4>
            <?php echo $form->field($model->getModel('profile'), 'firstname')->textInput(['maxlength' => 255]) ?>
            <?php echo $form->field($model->getModel('profile'), 'lastname')->textInput(['maxlength' => 255]) ?>
            <?php echo $form->field($model->getModel('profile'), 'middlename')->textInput(['maxlength' => 255]) ?>
            <?php echo $form->field($model->getModel('profile'), 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>
            <?php echo $form->field($model->getModel('profile'), 'gender')->dropDownlist([
                \common\models\UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Female'),
                \common\models\UserProfile::GENDER_MALE => Yii::t('frontend', 'Male')
            ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <h4><?php echo Yii::t('frontend', 'Account Settings') ?></h4>
            <?php echo $form->field($model->getModel('account'), 'username')->textInput(['disabled'=>'disabled']) ?>
            <?php echo $form->field($model->getModel('account'), 'email') ?>
            <?php echo $form->field($model->getModel('account'), 'password')->passwordInput() ?>
            <?php echo $form->field($model->getModel('account'), 'password_confirm')->passwordInput() ?>
            <div class="form-group">
                <br>
                <?php echo Html::submitButton(Yii::t('frontend', 'Update'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
