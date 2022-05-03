<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

// $this->title = 'Contact';
// $this->params['breadcrumbs'][] = $this->title;
?>




<div class="site-articole">
    
    <div class="body-content info_bloc arta_c2" style="opacity: 1;">    
        <div class="container relative">
            <div class="arta_c1_t">
                <div class="arta_c1_t_bg">
                    <h3 class="h_title7">Articole</h3>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 right">
                    <div class="artac1_sustin">
                        SUSTINUT DE:
                        <img src="/img/message_progress.png">
                        <img src="/img/top_educational.png">
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="body-content info_bloc" style="opacity: 1;">    
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="all_art_l">
                        <?php 
                        $knt0 = 0;
                        for ($i=0; $i < 6; $i++) {  $knt0++; ?>
                            <div class="row art_list_main <?=($knt0 % 2 == 0)?'par':'';?>">
                                <div class="col-lg-3">
                                    <div class="art_img_list">
                                        <a href="#">
                                            <img src="/img/client09.png">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="art_img_txt">
                                        <h3 class="art_title_list">Secretul dominarii</h3>
                                        <p>
                                            Orice bărbat, indiferent de vîrstă sau statut social poate fi un adevărat magnet de tipe super frumoase. Orice bărbat poate fi un rege absolut în patul oricăreia dintre ele. Echipa noastră e aici pentru a-ți oferi această posibilitate ție.
                                        </p>
                                    </div>
                                    <div class="right">
                                        <a href="<?=Yii::$app->urlManager->createUrl(['site/articole_view']);?>" class="btn_vezi_art">Vezi articolul</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="art_sideb">
                        <div class="art_sideb_pak center">
                            <a href="#"><img src="/img/pack2.png"></a>
                            <a class="btn_more_min" href="#"></a>
                        </div> 
                        <div class="art_sideb_pak center">
                            <a href="#"><img src="/img/pack1.png"></a>
                            <a class="btn_more_min" href="#"></a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>






</div>