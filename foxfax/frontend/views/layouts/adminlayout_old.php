<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\CabinetAsset::register($this);

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

    <header>
        <div class="wrap">
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
                     </ul>
                  </div>
               </div>
            </nav>
        </div>
    </header>

   
    <div class="cabinet-main">

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
