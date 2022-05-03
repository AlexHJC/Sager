<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="text-center"><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8 col-md-offset-2">
            <?php if (Yii::$app->session->hasFlash('success')){ ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i>Success</h4>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php } ?>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php echo $form->field($model, 'identity') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                        'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                    ]) ?>
                </div>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn standard-button btn-success', 'name' => 'login-button']) ?>
                </div>
                <div class="form-group">
                    <?php echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
                </div>
            <?php /*
 <h2><?php echo Yii::t('frontend', 'Log in with')  ?>:</h2>

               <div class="form-group">
                    <?php echo yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['/user/sign-in/oauth']
                    ]) ?>
                </div>
            */ ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>



                                <?php /*
                                <form action="https://app.xpirem.com/frontend/user_login_process" id="user_login" method="post" class="form-horizontal" name="user_login" accept-charset="utf-8">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Username or Email</label>
                                        <div class="col-sm-7">
                                            <input type="email"  class="form-control" id="user_email" name="user_email" placeholder="Email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                        <label class="checkbox pull-left col-sm-7">
                                        <input id="remember" name="remember" type="checkbox" checked="" style="display:inline;">
                                        Remember User ID </label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <button name="Submit" value="Login" type="submit" class="btn standard-button btn-success">Login</button>   
                                                    <input type="hidden" name="ci_csrf_token" value="">   
                                                </div>
                                                <div class="col-sm-9">
                                                    <div id="loginerrorinfo"  style="display:block;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center"><strong>Help:</strong> <a href="https://app.xpirem.com/frontend/forgot_password">I can't sign in or I forgot my username/password</a></div>
                                </form>
                                */ ?>