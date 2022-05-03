<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserCreateForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create new user';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form col-md-6">

        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'password')->passwordInput() ?>
        <?php echo $form->field($model, 'send_email')->checkbox() ?>

        <div class="form-group text-right" style="margin-top:30px">
            <?php echo Html::submitButton(Yii::t('frontend', 'Create new user'), ['class' => 'btn standard-button btn-success', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
