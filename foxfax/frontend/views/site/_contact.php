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
<?php /*
<div class="site-contact">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?php echo $form->field($model, 'name') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php echo $form->field($model, 'subject') ?>
                <?php echo $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                <?php echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
*/ ?>



<div class="site-contact">
    
    <div class="body-content info_bloc arta_c1">    
        <div class="container relative">
            <div class="arta_c1_t">
                <div class="arta_c1_t_bg">
                    <h3 class="h_title7">Contacte</h3>
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



    <div class="body-content info_bloc " style="opacity: 1;">    
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="h_title8">Contacte</h2>
                    <address class="adress_tag s_adress">
                        str. Bernardazzi 47, Chisinau
                    </address>
                    <address class="adress_tag s_mail">
                        promenclub@yahoo.com
                    </address>
                    <address class="adress_tag s_skpe">
                        promenclub999
                    </address>
                    <address class="adress_tag s_phone">
                        +37378554433
                    </address>
                </div>
                <div class="col-lg-6">
                    <p class="t_c_form center">
                        Dacă ai o întrebare sau  pur și simplu vrei să ne
                        spui ceva noi sîntem aici pentru a-ți răspunde
                    </p>    

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                        <?php echo $form->field($model, 'name', [
                            'template' => '<div class="row"><div class="col-sm-12">{input}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('name'),
                                'class' => 'form-control'
                            ],
                        ]); ?>
                        <?php echo $form->field($model, 'email', [
                            'template' => '<div class="row"><div class="col-sm-12">{input}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('email'),
                                'class' => 'form-control'
                            ],
                        ]); ?>
                        <?php echo $form->field($model, 'subject', [
                            'template' => '<div class="row"><div class="col-sm-12">{input}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('subject'),
                                'class' => 'form-control'
                            ],
                        ]); ?>

                        <?php echo $form->field($model, 'body',
                                [
                                    'template' => '<div class="row"><div class="col-sm-12">{input}</div></div>',
                                    'inputOptions' => [
                                        'placeholder' => $model->getAttributeLabel('body'),
                                        'class' => 'form-control'
                                    ],
                                ]
                            )->textArea(['rows' => 6])->label(false); ?>

                        <?php 
                            /*
                            echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            ])->label(false); 
                            */ 
                        ?> 

                    <div class="form-group right">
                    <?php echo Html::submitButton('', ['class' => 'btn_trimite', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>   

                </div>
            </div>
        </div>
    </div>






</div>