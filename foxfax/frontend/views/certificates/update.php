<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\web\UploadedFile;
use yii\web\Response;
use kartik\select2\Select2;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model frontend\models\Certificates */
if($model->isNewRecord){
	$this->title = Yii::t('form', 'Create Certificat Record');
}else{
	$this->title = Yii::t('form', 'Update {modelClass}: ', [
	    'modelClass' => 'Certificat record: ',
	]) . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="certificates-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="certificates-form">

	    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?=$form->field($model, 'product_id')->widget(Select2::classname(), [
                    'data' => $products,
                    'language' => Yii::$app->language,
                    'options' => [
                            'id' => 'select_prod',
                            'data-url' => Url::to(['certificates/getprod', 'id' => 'le_ID']),
                            'placeholder' => Yii::t('form', 'Select product ...')
                        ], 
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'title_en')->textInput(['id'=>'t_en', 'class' => 'form-control', 'readonly'=>'readonly' ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'title_fr')->textInput(['id'=>'t_fr', 'class' => 'form-control', 'readonly'=>'readonly']) ?>
            </div>
            <div class="col-md-4">
                <?=$form->field($model, 'parent_id')->widget(Select2::classname(), [
                    'data' => $lic_types,
                    'language' => Yii::$app->language,
                    'options' => [
                        // 'placeholder' => 'Select a state ...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
                <?php //=$form->field($model, 'type_id')->dropDownList($lic_types); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'expire')->textInput(['class' => 'dp form-control', ]) ?>
            </div>
            <div class="col-md-2">
                <?=$form->field($model, 'valable')->dropDownList(Yii::$app->params['yes']); ?>
            </div>


            <div class="col-md-4">
                <?=$form->field($model, 'company_id')->widget(Select2::classname(), [
                    'data' => $suppliers,
                    'language' => Yii::$app->language,
                    'options' => [
                        // 'placeholder' => 'Select a state ...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);?>
            </div>
            
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->field($model, 'comments')->widget(
                    \yii\imperavi\Widget::className(),
                    [
                        'plugins' => [
                            'fullscreen', 'fontcolor', 'video', 'advanced', 'format', 'bold', 'italic', 
                            'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule',
                            'bufferbuttons', 'scriptbuttons',
                            ],
                        'options'=>[
                            'minHeight'=>200,
                            'maxHeight'=>200,
                            'buttonSource'=>true,
                            'imageUpload'=>Yii::$app->urlManager->createUrl(['file-storage/upload-imperavi']),
                            // 'lang' => 'en',
                        ],
                    ]
                ) ?>
            </div>
        </div>

        <div class="row attach_sp">
            <div class="col-md-12">
                <div class="table-responsive table-widget">
                    
                    <table id="table_attach" class="table table-bordered">
                        <tr>
                            <th><i class="fa fa-tasks fa-fw"></i> File</th>
                            <th>Action</th>
                        </tr>
                        <?php if(isset($attachments)&&is_array($attachments)){ ?>
                            <?php foreach ($attachments as $key => $file) { ?>
                                <tr data-id="<?=$file->id;?>">
                                    <td>
                                        <a href="<?=$file->file;?>" target="_blank"><?=$file->file;?></a>
                                    </td>
                                    <td>
                                        <span class="rem_tr" onclick="remove_tr(this);">
                                            <i class="fa fa-trash-o"></i>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr class="hidden">
                            <td></td><td></td>
                        </tr>
                    </table>

                    <table class="hidden" id="attach_dell">
                        <tbody>
                            <tr><td>ID</td></tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-md-4">
                <div class="attach_sp_certif">
                    <?=$form->field($model, 'attachment')->widget(\mihaildev\elfinder\InputFile::className(), [
                        // 'language'      => 'ru',
                        
                        'controller'    => 'file-manager-elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                        'filter'        => [
                                            'image', 
                                            'application/msword', 
                                            'application/pdf', 'docx',
                                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                            ],    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span><span class="btn btn-success" id="addAtachBtn">+</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false,      // возможность выбора нескольких файлов
                    ])->label(false); ?>
                </div>
            </div>
           
        </div>
                
               








	    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('form', 'Create') : Yii::t('form', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('form', 'Cancel'), Url::to([Yii::$app->controller->id.'/index']), ['class' => 'btn btn-warning cancel_btn']) ?>
        </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
