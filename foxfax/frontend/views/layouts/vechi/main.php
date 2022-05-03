<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\LoginForm;


/* @var $this \yii\web\View */
/* @var $content string */

?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
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
                    <li class="<?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'articole'))?'active':'';?>">
                        <a href="<?=Yii::$app->urlManager->createUrl(['site/articole']);?>" class="item_main_menu">
                            <span>ARTICOLE</span>
                            <span class="men_img articole"></span>
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
                                    <span class="center">CABINET&nbsp; PERSONAL</span>
                                            <?php $model = new LoginForm(); ?>
                                            <?php $form = ActiveForm::begin([
                                                'id' => 'login-header',
                                                'action' => Yii::$app->urlManager->createUrl(['user/sign-in/login']),
                                                ]); ?>
                                            <?php echo $form->field($model, 'identity')->textInput(['placeholder' => 'Login or Email'])->label(false) ?>
                                            <?php echo $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
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
                                    

                                    <li class="dropdown header_user_pages">
                                        <ul class="user_head_men">
                                            <li class="hello_user">Hello <?=Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity();?></li>
                                            <li><?= Html::a(Yii::t('frontend', 'Settings'), ['user/default/index']) ?></li>
                                            <?php if(Yii::$app->user->can('manager')){ ?>
                                                <li><?= Html::a(Yii::t('frontend', 'Backend'), ['cabinet/index']) ?></li>
                                                <?php /*
                                                <li><?= Html::a(Yii::t('frontend', 'Backend'), Yii::getAlias('@backendUrl')) ?></li>
                                                */ ?>
                                            <?php } ?>
                                            <li><?= Html::a(Yii::t('frontend', 'Logout'), ['user/sign-in/logout'], ['data' => ['method' => 'post']]) ?></li>
                                        </ul>
                                        <?php /*
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"><?=Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity();?><b class="caret"></b></a>
                                        <ul id="w3" class="dropdown-menu">
                                            <li><?= Html::a(Yii::t('frontend', 'Settings'), ['user/default/index']) ?></li>
                                            <?php if(Yii::$app->user->can('manager')){ ?>
                                                <li><?= Html::a(Yii::t('frontend', 'Backend'), Yii::getAlias('@backendUrl')) ?></li>
                                            <?php } ?>
                                            <li><?= Html::a(Yii::t('frontend', 'Logout'), ['user/sign-in/logout'], ['data' => ['method' => 'post']]) ?></li>
                                        </ul>
                                        */ ?>
                                    </li>


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

    <?php if((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'index')){ ?>
        <?php echo \common\widgets\DbCarousel::widget([
            'key'=>'index',
            'options' => [
                'class' => 'slide index_slide', // enables slide effect
            ],
        ]) ?>
    <?php } ?>
    <div class="main_suport 
        <?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'index'))?'home':'';?>
        ">

        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php if(Yii::$app->session->hasFlash('alert')):?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ])?>
        <?php endif; ?>

        <!-- Example of your ads placing -->
        <?php echo \common\widgets\DbText::widget([
            'key' => 'ads-example'
        ]) ?>

        
        <div class="wrap">

            <?php echo $content ?>

        </div>


    </div>
    <footer class="footer">
        <div class="footer_social">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <span class="w_25">
                            <a href="#" class="social_f fb"></a>
                        </span>
                        <span class="w_25">
                            <a href="#" class="social_f pn"></a>
                        </span>
                        <span class="w_25">
                            <a href="#" class="social_f g"></a>
                        </span>
                        <span class="w_25">
                            <a href="#" class="social_f yt"></a>
                        </span>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
        <div class="footer_menu">
            <div class="container">
                <div class="row ">
                    <ul class="footer_menu_items">
                        <li class="itm i1"><a href="/<?=Yii::$app->language;?>/" class="logo_min_suport"><img src="/img/logo_min.png"></a></li>
                        <li class="itm menu_opt i2 <?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                            <a href="/<?=Yii::$app->language;?>/">
                                <span class="menu_f home"></span>
                            </a>
                        </li>
                        <li class="itm menu_opt i3 <?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'extralonglove'))?'active':'';?>">
                            <a href="<?=Yii::$app->urlManager->createUrl(['site/extralonglove']);?>">
                                <span class="menu_f extral"></span>
                            </a>
                        </li>
                        <li class="itm menu_opt i4 <?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'faq'))?'active':'';?>">
                            <a href="<?=Yii::$app->urlManager->createUrl(['site/faq']);?>">
                                <span class="menu_f faq"></span>
                            </a>
                        </li>
                        <li class="itm menu_opt i4 <?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'articole'))?'active':'';?>">
                            <a href="<?=Yii::$app->urlManager->createUrl(['site/articole']);?>">
                                <span class="menu_f articole"></span>
                            </a>
                        </li>
                        <li class="itm menu_opt i5 <?=((Yii::$app->controller->id == 'site')&&(Yii::$app->controller->action->id == 'contact'))?'active':'';?>">
                            <a href="<?=Yii::$app->urlManager->createUrl(['site/contact']);?>">
                                <span class="menu_f message"></span>
                            </a>
                        </li>
                        <li class="itm i6"><span class="powered_f"><?php echo Yii::powered() ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
