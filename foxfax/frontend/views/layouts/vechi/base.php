<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\LoginForm;
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">
    <div class="menu_absolute">
        <nav id="m1" class="navbar" role="navigation">
           <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w1-collapse">
                    <span class="sr-only">Menu</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                 </button>
                 <a class="navbar-brand" href="/<?=Yii::$app->language;?>/">
                    <img src="/img/logo.png">
                 </a>
              </div>
              <div id="w1-collapse" class="collapse navbar-collapse">
                 <ul id="m2" class="navbar-nav navbar-right nav">
                    <li class="<?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                        <a href="/<?=Yii::$app->language;?>/" class="item_main_menu">
                            <span>HOME</span> 
                            <span class="men_img home"></span>
                        </a>
                    </li>
                    <li class="<?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'extralonglove'))?'active':'';?>">
                        <a href="<?=Yii::$app->urlManager->createUrl(['site/extralonglove']);?>" class="item_main_menu">
                            <span>SUCCES 2 IN 1</span>
                            <span class="men_img extralonglove"></span>
                        </a>
                    </li>
                    <li class="<?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'faq'))?'active':'';?>">
                        <a href="<?=Yii::$app->urlManager->createUrl(['site/faq']);?>" class="item_main_menu">
                            <span>INTREBARI/RASPUNSURI</span>
                            <span class="men_img faq"></span>
                        </a>
                    </li>
                    <li class="<?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'contact'))?'active':'';?>">
                        <a href="<?=Yii::$app->urlManager->createUrl(['site/contact']);?>" class="item_main_menu">
                            <span>CONTACTE</span>
                            <span class="men_img contact"></span>
                        </a>
                    </li>
                    <li class="cap_pers_menu">
                        <ul class="login_sup">
                            <?php  if(Yii::$app->user->isGuest){ ?>
                                <li class="log_f_d">
                                    CABINET PERSONAL   LOGIN
                                            <?php $model = new LoginForm(); ?>
                                            <?php $form = ActiveForm::begin([
                                                'id' => 'login-header',
                                                'action' => Yii::$app->urlManager->createUrl(['user/sign-in/login']),
                                                ]); ?>
                                            <?php echo $form->field($model, 'identity')->label(false) ?>
                                            <?php echo $form->field($model, 'password')->passwordInput()->label(false) ?>
                                            <div class="hidden">
                                                <?php echo $form->field($model, 'rememberMe')->checkbox(['class' => 'hidden', 'value' => 0])->label(false) ?>
                                            </div>
                                            <?php /*
                                            <div style="color:#999;margin:1em 0">
                                                <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                                                    'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                                                ]) ?>
                                            </div>
                                            */ ?>
                                            <div class="form-group center">
                                                <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                            </div>
                                        <?php ActiveForm::end(); ?>

                                </li>
                                <li class="log_new_urs">
                                    <?php echo Html::a('', ['user/sign-in/signup'], ['class' => 'add_n_u']) ?>
                                </li>
                            <?php  }else{ ?>
                                    <?= Html::a(Yii::t('frontend', 'Logout'), ['user/sign-in/logout'], ['data' => ['method' => 'post']]) ?>
                            <?php } ?>
                        </ul>
                    </li>

                    <?php /*
                    <li class="dropdown">
                       <a class="dropdown-toggle" href="#" data-toggle="dropdown">admin <b class="caret"></b></a>
                       <ul id="w3" class="dropdown-menu">
                          <li><a href="/ru/user/default/index" tabindex="-1">Настройки</a></li>
                          <li><a href="http://colea.md/admin" tabindex="-1">Панель управления</a></li>
                          <li><a href="/ru/user/sign-in/logout" data-method="post" tabindex="-1">Выход</a></li>
                       </ul>
                    </li>
                    <li class="dropdown">
                       <a class="dropdown-toggle" href="#" data-toggle="dropdown">Язык <b class="caret"></b></a>
                       <ul id="w4" class="dropdown-menu">
                          <li class="active"><a href="/ru" tabindex="-1">Русский (РФ)</a></li>
                          <li><a href="/ro" tabindex="-1">Romina (RO)</a></li>
                       </ul>
                    </li>
                    */ ?>
                 </ul>
              </div>
           </div>
        </nav>
    </div>
    <?php
    /*
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar',  // navbar-inverse navbar-fixed-top
        ],
    ]); 
    ?>
    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']],
            // ['label' => Yii::t('frontend', 'About'), 'url' => ['/page/view', 'slug'=>'about']],
            // ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
            ['label' => Yii::t('frontend', 'ExtraLongLove'), 'url' => ['/site/extralonglove']],
            ['label' => Yii::t('frontend', 'ArtaSeductiei'), 'url' => ['/site/artaseductiei']],
            ['label' => Yii::t('frontend', 'Intrebari/Raspunsuri'), 'url' => ['/site/faq']],
            ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],

            ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
            ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible'=>Yii::$app->user->isGuest],
            [
                'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                'visible'=>!Yii::$app->user->isGuest,
                'items'=>[
                    [
                        'label' => Yii::t('frontend', 'Settings'),
                        'url' => ['/user/default/index']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Backend'),
                        'url' => Yii::getAlias('@backendUrl'),
                        'visible'=>Yii::$app->user->can('manager')
                    ],
                    [
                        'label' => Yii::t('frontend', 'Logout'),
                        'url' => ['/user/sign-in/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ],
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function ($code) {
                    return [
                        'label' => Yii::$app->params['availableLocales'][$code],


                        'url' => [Yii::$app->controller->id.'/'.Yii::$app->controller->action->id, 'locale'=> $code],
                        // 'url' => ['/site/set-locale', 'locale'=>$code],
                        'active' => Yii::$app->language === $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ]
        ]
    ]); ?>
    <?php NavBar::end(); */ ?>

    <?php echo $content ?>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?php echo date('Y') ?></p>
        <p class="pull-right"><?php echo Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endContent() ?>