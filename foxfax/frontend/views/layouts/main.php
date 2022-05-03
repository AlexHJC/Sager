<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/* @var $content string */

use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\LoginForm;
use yii\db\Expression;

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




            

            <!-- INCLUDE THE HEADER FILE HERE --> 
        <header class="header top-header">
            <div class="top-bar">
                <div class="container">
                    <nav class="navbar" role="navigation" style="margin-bottom: 0">
                        <div class="row">
                            <!-- logo -->
                            <div class="col-md-2 logo"> 
                              <a href="/<?=Yii::$app->language;?>" class="logo"> 
                                <img src="/images/logo-fox-fax.png" alt="Logo" style=" max-width:120px !important;"/
                                > 
                              </a> 
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-9">
                                        <!-- responsive menu bar icon --> 
                                        <a href="#" class="hidden-md hidden-lg main-nav-toggle"><i class="fa fa-bars"></i></a>
                                        <!-- end responsive menu bar icon -->
                                        <div class="top-bar-right admin_welcometext">
                                            <?=Yii::t('site', 'Welcome');?> <?=Yii::$app->user->identity->username;?> !   | 
                                            <a href="<?=Yii::$app->urlManager->createUrl(['user/default/index']);?>">
                                                <i class="fa fa-user fa-fw"></i>
                                                <?=Yii::t('site', 'Account');?>
                                            </a>                
                                        </div>
                                        <div class="pull-right tooltips btn-fit-height"> <i class="fa fa-calendar"></i>&nbsp; 
                                            <span class="thin-uppercase"><?=date('D d/m/Y');?></span> 
                                        </div>
                                        <div class="top-bar-right lang_change">
                                            <?=common\components\languageSwitcher::Widget();?>          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <div class="main-wrapper">
            <div class="row">
                <div class="container">
                    <section class="bottom">
                        <!-- INCLUDE LEFT BAR FILE HERE --> 
                        <!-- left sidebar -->
                        <div class="col-md-2 col-xs-12 left-sidebar">
                            <nav class="main-nav">
                                <ul class="main-menu">
                                    <li> <a href="/<?=Yii::$app->language;?>">
                                            <i class="fa fa-dashboard fa-fw"></i> 
                                            <span class="text"> <?=Yii::t('site', 'Dashboard');?> </span> 
                                        </a> 
                                    </li>
                                    <?php if(!empty($this->params['bIsAccount'])) { ?>

                                        <li class="<?=(Yii::$app->controller->id == 'subscription')?'active':'';?>"">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['subscription/check-status']);?>">
                                            <i class="fa fa-dashboard fa-user"></i>
                                            <span class="text"> <?=Yii::t('site', 'Subscription');?> </span>
                                        </a>
                                        </li>

                                    <?php } ?>
                                    <li  class="<?=(Yii::$app->controller->id == 'certificates' || Yii::$app->controller->id == 'certificates-types')?'active':'';?>">
                                        <a href="document_dashboard" class="js-sub-menu-toggle">
                                            <i class="fa fa-certificate fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'Certificates');?>         
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'certificates' || Yii::$app->controller->id == 'certificates-types')||(Yii::$app->controller->id == 'certificates-types-items')?'open':'';?>">
                                           
                                            <li class="<?=((Yii::$app->controller->id == 'certificates')&&(Yii::$app->controller->action->id == 'createmultimple'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['certificates/createmultimple']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'Add Record');?></span>        
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'certificates'))?'active-subcat':'';?>">
                                                <a class='company-name js-sub-menu-toggle2' href="<?=Yii::$app->urlManager->createUrl(['certificates/index']);?>">
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class='text'><?=Yii::t('site', 'My Certificates');?></span>
                                                    <i class="toggle-icon fa fa-angle-left"></i>        
                                                </a>
                                                <ul class="sub-menu2 <?=(Yii::$app->controller->id == 'certificates')?'open':'';?>">
		                                            <li class="<?=(Yii::$app->controller->id == 'certificates' && Yii::$app->controller->action->id == 'index')?'active':'';?>">
	                                                    <a href="<?=Yii::$app->urlManager->createUrl(['certificates/index']);?>">
	                                                        <i class="fa fa-circle-o l_style1"></i>
	                                                        <span class="text"><?=Yii::t('site', 'All');?></span>
	                                                    </a>
	                                                </li>
		                                            <?php 

                                                    $nAccountId = (!empty(Yii::$app->user->identity->parent_id)) ? Yii::$app->user->identity->parent_id : Yii::$app->user->identity->id;
		                                            $type_count = ArrayHelper::map(
		                                                        frontend\models\Certificates::find()
		                                                        ->select(['id', 'title_en', 'title_fr', 'parent_id', 'type_id'])
		                                                        ->asArray()
		                                                        ->where(['valable' => 'yes', 'account_id' => $nAccountId])
		                                                        ->all(), 
		                                                        'id', 'title_'.Yii::$app->language, 'type_id');

		                                            $cert_cat = frontend\models\CertificatesTypes::find()
		                                                        ->where(['status' => 'active'])
		                                                        // ->andwhere(['parent_id' => '0'])
		                                                        ->orderBy('position ASC')
		                                                        ->all();

		                                            foreach ($cert_cat as $key => $cert) { ?>
		                                                <li class="<?=(Yii::$app->controller->id == 'certificates' && Yii::$app->controller->action->id == 'indexcat' && Yii::$app->request->get('p_id') == $cert->id)?'active':'';?>">
		                                                    <a href="<?=Url::to(['certificates/indexcat', 'p_id' => $cert->id]);?>">
		                                                        <i class="fa fa-circle-o l_style1"></i>
		                                                        <span class="text"><?=$cert->title;?> <?=Yii::t('site', 'Certificates');?></span>
		                                                        <span class="badge element-bg-color-blue pull-right">
		                                                            <?php if(isset($type_count[$cert->id])&&(count($type_count[$cert->id])>0)){
		                                                                echo count($type_count[$cert->id]);
		                                                            }else{
		                                                                echo "0";
		                                                            } ?>    
		                                                        </span>
		                                                    </a>
		                                                </li>
		                                            <?php } ?>
		                                        </ul>
                                            </li>
                                             <li class="<?=((Yii::$app->controller->id == 'certificates-types')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['certificates-types/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"> <?=Yii::t('site', 'Categories');?> </span>
                                                </a> 
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'certificates-types-items')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['certificates-types-items/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"> <?=Yii::t('site', 'Subcategories');?> </span>
                                                </a> 
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <?php /*
                                    <li  class="<?=(Yii::$app->controller->id == 'products')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['products/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-newspaper-o fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'My Certificates');?>        
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'products')?'open':'';?>">
                                            <?php 

                                            $type_count = ArrayHelper::map(
                                                        frontend\models\Certificates::find()
                                                        ->select(['id', 'title_en', 'type_id'])
                                                        ->asArray()
                                                        ->where(['valable' => 'yes'])
                                                        ->all(), 
                                                        'id', 'title_en', 'type_id');

                                            $cert_cat = frontend\models\CertificatesTypes::find()
                                                        ->where(['status' => 'active'])
                                                        // ->andwhere(['parent_id' => '0'])
                                                        ->orderBy('position ASC')
                                                        ->all();

                                            foreach ($cert_cat as $key => $cert) { ?>
                                                <li class="">
                                                    <a href="<?=Url::to(['certificates/indexcat', 'id' => $cert->id]);?>">
                                                        <i class="fa fa-circle-o l_style1"></i>
                                                        <span class="text"><?=$cert->title;?> <?=Yii::t('site', 'Certificates');?></span>
                                                        <span class="badge element-bg-color-blue pull-right">
                                                            <?php if(isset($type_count[$cert->id])&&(count($type_count[$cert->id])>0)){
                                                                echo count($type_count[$cert->id]);
                                                            }else{
                                                                echo "0";
                                                            } ?>    
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    */ ?>

                                    <li  class="<?=(Yii::$app->controller->id == 'products')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['products/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-newspaper-o fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'Products');?>        
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'products')?'open':'';?>">
                                            <li class="<?=((Yii::$app->controller->id == 'products')&&(Yii::$app->controller->action->id == 'create'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['products/create']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'New Product');?></span>        
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'products')&&(Yii::$app->controller->action->id == 'import'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['products/import']);?>">
                                                    <i class='fa fa-file-upload '></i>
                                                    <span class='text'><?=Yii::t('site', 'Import Product');?></span>
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'products')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['products/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'List Products');?></span>
                                                </a> 
                                            </li>
                                        </ul>
                                    </li>
                                    <li  class="<?=(Yii::$app->controller->id == 'companies')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['companies/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-university fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'Companies');?>        
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'companies')?'open':'';?>">
                                            <li class="<?=((Yii::$app->controller->id == 'companies')&&(Yii::$app->controller->action->id == 'create'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['companies/create']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'New Company');?></span>        
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'companies')&&(Yii::$app->controller->action->id == 'import'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['companies/import']);?>">
                                                    <i class='fa fa-upload '></i>
                                                    <span class='text'><?=Yii::t('site', 'Import Companies');?></span>
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'companies')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['companies/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'List Companies');?></span>
                                                </a> 
                                            </li>
                                        </ul>
                                    </li>
                                  <!--  <li  class="<?=(Yii::$app->controller->id == 'countries')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['countries/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-dribbble fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'Countries');?>        
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'countries')?'open':'';?>">
                                            <li class="<?=((Yii::$app->controller->id == 'countries')&&(Yii::$app->controller->action->id == 'create'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['countries/create']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'New Country');?></span>        
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'countries')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['countries/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'List Countries');?></span>
                                                </a> 
                                            </li>
                                        </ul>
                                    </li>-->
                                    
                                    <li  class="<?=(Yii::$app->controller->id == 'alerts')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['alerts/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-bell-o fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'Alerts');?>        
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <?php
                                            $alert_menu = array('notifications', 'labels', 'periods', 'alerts');
                                        ?>
                                        <ul class="sub-menu <?=(in_array(Yii::$app->controller->id, $alert_menu))?'open':'';?>">
                                            <li class="<?=((Yii::$app->controller->id == 'alerts')&&(Yii::$app->controller->action->id == 'create'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['alerts/create']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'New Alert');?></span>        
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'alerts')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['alerts/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'List Alerts');?></span>
                                                </a> 
                                            </li>
                                            <li class="<?=(Yii::$app->controller->id == 'notifications')?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['notifications/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-bolt'></i>
                                                    <span class="text"><?=Yii::t('site', 'Notifications');?></span>
                                                </a> 
                                            </li>
                                            <li class="<?=(Yii::$app->controller->id == 'periods')?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['periods/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-calendar-check-o'></i>
                                                    <span class="text"><?=Yii::t('site', 'Notification Periods');?></span>
                                                </a> 
                                            </li>
                                            
                                            <li class="<?=(Yii::$app->controller->id == 'labels')?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['labels/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-ravelry'></i>
                                                    <span class="text"><?=Yii::t('site', 'Labels');?></span>
                                                </a> 
                                            </li>
                                        </ul>
                                    </li>

                                    <li  class="<?=(Yii::$app->controller->id == 'reminders')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['reminders/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-newspaper-o fw"></i> 
                                            <span class="text">
                                                <?=Yii::t('site', 'Reminders');?>        
                                            </span> 
                                            <i class="toggle-icon fa fa-angle-left"></i> 
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'reminders')?'open':'';?>">
                                            <li class="<?=((Yii::$app->controller->id == 'reminders')&&(Yii::$app->controller->action->id == 'create'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['reminders/create']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'New Reminder');?></span>        
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'reminders')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['reminders/index']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'List All Reminder');?></span>
                                                </a> 
                                            </li>
                                         <!--   <li class="<?=((Yii::$app->controller->id == 'reminders')&&(Yii::$app->controller->action->id == 'waiting'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['reminders/waiting']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'Waiting');?></span>
                                                </a> 
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'reminders')&&(Yii::$app->controller->action->id == 'sended'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['reminders/sended']);?>" class="main-menu"> 
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'Sended');?></span>
                                                </a> 
                                            </li> -->
                                            
                                        </ul>
                                    </li>

                                    <?php if(!empty($this->params['bIsAccount'])) { ?>
                                    <li  class="<?=(Yii::$app->controller->id == 'users')?'active':'';?>">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['users/index']);?>" class="js-sub-menu-toggle">
                                            <i class="fa fa-dribbble fw"></i>
                                            <span class="text">
                                                <?=Yii::t('site', 'Users');?>
                                            </span>
                                            <i class="toggle-icon fa fa-angle-left"></i>
                                        </a>
                                        <ul class="sub-menu <?=(Yii::$app->controller->id == 'users')?'open':'';?>">
                                            <li class="<?=((Yii::$app->controller->id == 'users')&&(Yii::$app->controller->action->id == 'create'))?'active':'';?>">
                                                <a class='company-name' href="<?=Yii::$app->urlManager->createUrl(['users/create']);?>">
                                                    <i class='fa fa-plus '></i>
                                                    <span class='text'><?=Yii::t('site', 'New Users');?></span>
                                                </a>
                                            </li>
                                            <li class="<?=((Yii::$app->controller->id == 'users')&&(Yii::$app->controller->action->id == 'index'))?'active':'';?>">
                                                <a href="<?=Yii::$app->urlManager->createUrl(['users/index']);?>" class="main-menu">
                                                    <i class='fa fa-align-justify'></i>
                                                    <span class="text"><?=Yii::t('site', 'List Users');?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>

                                    

                                    <?php /*
                                    <li class="">
                                        <a href="document_dashboard" class="js-sub-menu-toggle"><i class="fa fa-clipboard fa-fw"></i> <span class="text"> Documents </span> <i class="toggle-icon fa fa-angle-down"></i> </a>
                                        <ul class="sub-menu">
                                            <li> <a href="#" class="main-menu"> <span class="text"> New Document Type </span> </a>         
                                            </li>
                                            <li >
                                                <a href="#"  >
                                                    <div class='dot-badge-wrapper'>
                                                        <div class='dot-badge'  ></div>
                                                        <div class='dot-badge'></div>
                                                        <div class='dot-badge'></div>
                                                    </div>
                                                    <span class='text'>Commercial License</span><span class='badge element-bg-color-blue pull-right'>0</span>
                                                </a>
                                            </li>
                                            <li >
                                                <a href="#" >
                                                    <div class='dot-badge-wrapper'>
                                                        <div class='dot-badge'  ></div>
                                                        <div class='dot-badge'></div>
                                                        <div class='dot-badge'></div>
                                                    </div>
                                                    <span class='text'>Employment Contract</span><span class='badge element-bg-color-blue pull-right'>0</span>
                                                </a>
                                            </li>
                                            <li >
                                                <a href="#"  >
                                                    <div class='dot-badge-wrapper'>
                                                        <div class='dot-badge'  ></div>
                                                        <div class='dot-badge'></div>
                                                        <div class='dot-badge'></div>
                                                    </div>
                                                    <span class='text'>Health Card</span><span class='badge element-bg-color-blue pull-right'>0</span>
                                                </a>
                                            </li>
                                            <li >
                                                <a href="#"  >
                                                    <div class='dot-badge-wrapper'>
                                                        <div class='dot-badge'  ></div>
                                                        <div class='dot-badge'></div>
                                                        <div class='dot-badge'></div>
                                                    </div>
                                                    <span class='text'>Passports</span><span class='badge element-bg-color-blue pull-right'>0</span>
                                                </a>
                                            </li>
                                            <li >
                                                <a href="#" >
                                                    <div class='dot-badge-wrapper'>
                                                        <div class='dot-badge'  ></div>
                                                        <div class='dot-badge'></div>
                                                        <div class='dot-badge'></div>
                                                    </div>
                                                    <span class='text'>Residents Permit</span><span class='badge element-bg-color-blue pull-right'>0</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li  > 
                                        <a href="#" class="main-menu"><i class="fa fa-envelope fa-fw"></i> 
                                        <span class="text"> Contacts </span> </a> 
                                    </li>
                                    
                                    <li class="">
                                        <a href="javascript:void(0);" class="js-sub-menu-toggle"><i class="fa fa-desktop fa-fw"></i> <span class="text"> Customize </span> <i class="toggle-icon fa fa-angle-left"></i> </a>
                                        <ul class="sub-menu documents_list customize_list" style="display:none">
                                            <li > <a href="#"  > <span class="text">Document Templates</span> </a> </li>
                                            <li > <a href="#"  > <span class="text">Email Templates</span> </a> </li>
                                            <li > <a href="#"  > <span class="text">Labels</span> </a> </li>
                                        </ul>
                                    </li>

                                    <li  >
                                        <a href="document_dashboard" class="js-sub-menu-toggle"><i class="fa fa-file-text fa-fw"></i> <span class="text"> Reports </span> <i class="toggle-icon fa fa-angle-left"></i> </a> 
                                        <ul class="sub-menu" style="display:none">
                                            <li > <a href="/reports/search_document"  > <span class="text">Search</span> </a> </li>
                                            <li > <a href="/reports/document_field_list"  > <span class="text">Selective search</span> </a> </li>
                                            <li > <a href="/reports/document_list"  > <span class="text">Document List</span> </a> </li>
                                            <li > <a href="/reports/document_expiry_list"  > <span class="text">Expiration list</span> </a> </li>
                                            <li > <a href="/reports/document_label_list"  > <span class="text">Labels based report</span> </a> </li>
                                        </ul>
                                    </li>
                                    */ ?>
                                    
                                    <li>
                                        <a href="<?=Yii::$app->urlManager->createUrl(['user/sign-in/logout']);?>" data-method="post">
                                            <i class="fa fa-power-off fa-fw"></i> 
                                            <span class="text"><?=Yii::t('site', 'Logout');?></span> 
                                        </a> 
                                    </li>
                                </ul>
                            </nav>
                            <!-- /main-nav -->
                            <!--<div class="sidebar-minified js-toggle-minified"> <i class="fa fa-angle-left"></i> </div>-->
                            <!-- sidebar content -->
                            <!-- end sidebar content --> 
                        </div>
                        <!-- end left sidebar -->
                        
                        

                        <div class="col-md-10 content-wrapper">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        if(isset($this->params['breadcrumbs'][0])){
                                            $controller_brad = $this->params['breadcrumbs'][0];
                                        }
                                        $this->params['breadcrumbs'] = [];
                                        if(Yii::$app->controller->action->id != 'index'){
                                            $this->params['breadcrumbs'][] = $controller_brad;
                                            // $this->params['breadcrumbs'][] = [
                                            //     'label' => Html::encode($this->title),  
                                            //     'url' => Yii::$app->urlManager->createUrl(['periods/index']),     
                                            // ];
                                        }
                                        $this->params['breadcrumbs'][] = $this->title;

                                        echo yii\widgets\Breadcrumbs::widget([
                                            'homeLink' => ['label' => 'Home',
                                                'url' => Yii::$app->getHomeUrl(),
                                                'template' => "<li><i class='fa fa-home'></i>{link}</li>\n", 
                                                ],
                                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                        ]);
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="top-content">
                                        <ul class="list-inline mini-stat">
                                            <li>
                                                <h5>
                                                    <?=Yii::t('site', 'DOCUMENTS');?>
                                                    <a href="<?=Url::to(['certificates/createmultimple']);?>" title="Create" style="font-size: 16px;">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </a>
                                                    <span class="stat-value stat-color-blue">

                                                        <a href="<?=Url::to(['certificates/index?sort=-expire']);?>" title="Active">
                                                            <i class="fa fa-check"></i> <?php echo $this->params['nDocActive'];?>
                                                        </a> /
                                                        <a href="<?=Url::to(['certificates/index?sort=expire']);?>" title="Expired">
                                                            <i class="fa fa-warning"></i> <?php echo $this->params['nDocExpired'];?>
                                                        </a>
                                                    </span>
                                                </h5>
                                            </li>
                                            <li>
                                                <h5>
                                                    <?=Yii::t('site', 'REMINDERS');?> 
                                                    <span class="stat-value stat-color-seagreen">
                                                        <a href="<?=Url::to(['reminders/index']);?>">
                                                            <i class="fa fa fa-list"></i> 
                                                            <?php echo $this->params['nReminder']; ?>
                                                        </a>
                                                    </span> 
                                                </h5>
                                                <span id="mini-bar-chart3" class="mini-bar-chart"></span> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--charts styles-->
                            <div class="content">


                                <?=$content;?>


                            </div>
                        </div>

                        <div id="ajax_loading">
                            <img src="/images/loading.gif">
                        </div>


                        <!--/.content-wrapper--> 
                    </section>
                </div>
                <!--/.container--> 
            </div>
            <!--/main-row--> 
        </div>
        <!--/.main-wrapper--> 
      
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="footerleft_content">
                            <p> COPYRIGHT © 2019. ALL RIGHTS RESERVED TO : <a href="https://relaxat.ca">relaxat.ca</a></p>
                        </div>
                    </div>
                   <div class="col-md-4">
                        <ul class="social_media">
                            <li class="twitter">
                                <a title="Twitter" href="#" target="_blank" class="icon-twitter">
                                    <i class="fa fa-twitter"></i>
                                    <span><?=Yii::t('site', 'Follow Us On Twitter');?></span>
                                </a>
                            </li>
                            <li class="facebook">
                                <a title="Facebook" href="#" target="_blank" class="icon-facebook">
                                    <i class="fa fa-facebook"></i>
                                    <span><?=Yii::t('site', 'Follow Us On FaceBook');?></span>
                                </a>
                            </li>
                            <li class="linkedin">
                                <a title="Linkedin" href="#" target="_blank" class="icon-flickr">
                                    <i class="fa fa-linkedin"></i>
                                    <span><?=Yii::t('site', 'Follow Us On Linked In');?></span>
                                </a>
                            </li>
                            <li class="gplus">
                                <a title="Google +" href=" #" rel="publisher" target="_blank" class="icon-gplus">
                                    <i class="fa fa-google-plus"></i>
                                    <span><?=Yii::t('site', 'Follow Us On Google+');?></span>
                                </a>
                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
            <!--/.container-->
        </footer>

        





<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
