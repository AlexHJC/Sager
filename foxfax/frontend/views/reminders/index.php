<?php

use yii\helpers\Html;
// use yii\grid\GridView;
// use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RemindersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('form', 'Reminders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reminders-index">
<?php /*
    <a class="exp_by_tb btn btn-success" href="javascript:void(0);" data-id="company_sup">
        <i class="fa fa-cloud-download"></i> Export table data
    </a>
*/ ?>


    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a('<i class="fa fa-plus-circle"></i> '.Yii::t('form', 'Create new'), ['create'], ['class' => 'add_new']) ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?php
// print_r($dataProvider);
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        // 'id',
        [
                'class'=>'kartik\grid\CheckboxColumn',
        ],
        [
            'label' => 'Certificat',
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'certificatName', 
            'vAlign'=>'middle',
        ],
        // [
        //     'label' => 'Product',
        //     'class'=>'kartik\grid\DataColumn',
        //     'attribute'=>'productName', 
        //     'vAlign'=>'middle',
        // ],
        [
            'label' => 'Company',
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'companyName', 
            'vAlign'=>'middle',
        ],
        [
            'label' => 'Type',
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'typeName', 
            'vAlign'=>'middle',
        ],
        [
            'format' => 'html',
            'attribute'=>'label_id', 
            'value'=>function ($model, $key, $index, $widget) { 
                return '<span class="label_state" style="background-color:#'.$model->label['color'].'">'.$model->labelName.'</span>';
            }
        ],
        
        // 'certificat_id',
        // 'product_id',
        // 'company_id',
        // 'certificat_type',
        'state',
        [
            'attribute'=>'date_alert', 
            'format'=>['date', 'php:d-m-Y'], 
            'width'=>'100px'
        ],
        [
            'attribute'=>'last_send', 
            'format'=>['date', 'php:d-m-Y'], 
            'width'=>'100px'
        ],
        // 'status',
        // 'comment:ntext',
        [
            'vAlign' => 'middle', 
            'vAlign' => false,
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}{resend}{update}{delete}',
            'viewOptions'  =>['title'=>Yii::t('form', 'view'), 'data-toggle'=>'tooltip'],
            'updateOptions'=>['title'=>Yii::t('form', 'update'), 'data-toggle'=>'tooltip'],
            'deleteOptions'=>['title'=>Yii::t('form', 'delete'), 'data-toggle'=>'tooltip'], 
            //'resendOptions'=>['title'=>Yii::t('form', 'resend'), 'data-toggle'=>'tooltip'], 
            'width'=>'100px'
        ],
        // ['class' => 'kartik\grid\CheckboxColumn']
    ];
    echo GridView::widget([
        'id' => 'wgrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'autoXlFormat'=>true,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
            ['content'=>
                '{export}'.' '.
                 Html::button('Bulk Reminders', ['type' => 'button', 'title' => 'Bulk Reminders', 'data-url' => Yii::$app->urlManager->createAbsoluteUrl('reminders/bulk-resend'), 'class' => 'btn btn-success', 'onclick' => 'bulkReminders(this)', 'style' => 'margin-left: 15px;height: 30px;padding: 2px 15px;font-weight: bold;']) . ' '
            ],
        ],
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        'exportConfig' => [
            GridView::CSV => ['label' => 'CSV'],
            // GridView::HTML => ['label' => 'HTML'],
            GridView::PDF => ['label' => 'PDF'],
            GridView::EXCEL => ['label' => 'XLS'],
        ],
        'pjax' => true,
        'bordered' => false,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => false,
        'pageSummaryRowOptions' => [
            ['class' => 'kv-page-summary warning']
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            '{pager}',
            'heading' =>false,
        ],
    ]);

    
    ?>
    </div>