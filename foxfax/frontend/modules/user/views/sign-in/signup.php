<?php

use frontend\models\Cities;
use frontend\models\States;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('frontend', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-7">
                <h1 class="text-center"><?php echo Html::encode($this->title) ?></h1>
                <div class="form-group">
                    <?php echo Html::a(Yii::t('frontend', 'Already have an account? Sign In.'), ['login']) ?>
                </div>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?php echo $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput(['value'=>''])?>
                <?= $form->field($model, 'password_confirm')->passwordInput(['value'=>''])?>

                <?= $form->field($model, 'company')->textInput(['class' => 'form-control', ]) ?>

                <?php
                    echo $form->field($model, 'country_id')->dropDownList($countries,
                         [
                             'options' => [$nDefaultCountryId =>['Selected'=>true]],
                            'prompt'=>'Country',
                            'onchange'=>'
                                $.get( "'.Yii::$app->urlManager->createAbsoluteUrl('/ajax/get-states').'", { id: $(this).val() } )
                                .done(function( data ) {
                                    $( "#'.Html::getInputId($model, 'state_id').'" ).html( data );
                                }
                            );'
                        ]
                    );

                    ?>
                <?php
                    echo $form->field($model, 'state_id')->dropDownList($states, array(
                        'prompt'=>'State/Province',
                        'onchange'=>'
                                $.get( "'.Yii::$app->urlManager->createAbsoluteUrl('/ajax/get-cities').'", { id: $(this).val() } )
                                .done(function( data ) {
                                    $( "#'.Html::getInputId($model, 'city_id').'" ).html( data );
                                }
                            );'

                    ));
                    ?>
                <?php
                    echo $form->field($model, 'city_id')->dropDownList(array(), array(
                        'prompt'=>'Select City'

                    ));
                    ?>
                <?php
                    echo $form->field($model, 'postal_code')->textInput();
                    ?>

                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn standard-button btn-success', 'name' => 'signup-button']) ?>
                </div>

                <?php /*
 <h2><?php echo Yii::t('frontend', 'Sign up with')  ?>:</h2>
                <div class="form-group">
                    <?php echo yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['/user/sign-in/oauth']
                    ]) ?>
                </div>
            */ ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-md-5">
                <h1 class="text-center">Your Plan</h1>
                <div class="col-md-12 text-center">
                    <h2><?php echo $plan->plan_title;?></h2>
                    <h3>
                        <?php echo money_format('%i', $plan->plan_price_month);?> / month
                    </h3>
                        <h3><?php echo $plan->plan_doc_limit;?> documents</h3>
                        <h3><?php echo $plan->plan_user_limit;?> accounts</h3>
                </div>
            </div>
        </div>
    </div>
</div>
