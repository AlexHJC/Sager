<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView2;
// use yii\widgets\Pjax;
use kartik\grid\GridView as GridView2;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CertificatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('form', 'Certificates').': '.$type->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-index">
    <div class="row">
        <div class="col-md-10">
            <h1>
                <?= Html::encode($this->title) ?>
                <?= Html::a('<i class="fa fa-plus-circle"></i> '.Yii::t('form', 'Create new record'), ['createmultimple'], ['class' => 'add_new']) ?>
            </h1>
        </div>
        <div class="col-md-2 export_config_sp text-right">
            <?php
            
            $exportColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                'id',
                // [
                //     'attribute'=>'type_id', 
                //     'width'=>'310px',
                //     'value'=>function ($model, $key, $index, $widget) { 
                //         return $model->typeName;
                //     },
                //     'filterType'=>GridView2::FILTER_SELECT2,
                //     'filter'=>ArrayHelper::map(CertificatesTypes::find()->orderBy('title_'.Yii::$app->language)->asArray()->all(), 'id', 'title_'.Yii::$app->language), 
                //     'filterWidgetOptions'=>[
                //         'pluginOptions'=>['allowClear'=>true],
                //     ],
                //     'filterInputOptions'=>['placeholder'=>'Any supplier'],
                //     'group'=>true,  // enable grouping
                // ],
                [
                    'attribute'=>'parent_id', 
                    'width'=>'250px',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return $model->parentName;
                    },
                    'filterType'=>GridView2::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map(CertificatesTypesItems::find()->orderBy('parent_id')->asArray()->all(), 'id', 'title_'.Yii::$app->language), 
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Any type'],
                    'group'=>true,  // enable grouping
                    // 'subGroupOf'=>1 // supplier column index is the parent group
                ],
                'title_en',
                'title_fr',
                [
                    'label' => 'Category',
                    'class'=>'kartik\grid\DataColumn',
                    'attribute'=>'parent_id', 
                    'value'=>function ($model, $key, $index) { 
                        $cat = CertificatesTypesItems::find()->where(['id' => $model->parent_id])->one();
                        return $cat['title'];
                    },
                    'group'=>true,  // enable grouping
                    'groupedRow'=>true,  
                    // 'subGroupOf'=>1 // supplier column index is the parent group
                ],
                [
                    'label' => 'Type',
                    'class'=>'kartik\grid\DataColumn',
                    'attribute'=>'typeName', 
                    'vAlign'=>'middle',
                ],
                // 'type_id',
                [
                    'attribute'=>'added', 
                    'format'=>['date', 'php:d-m-Y'], 
                    'width'=>'100px'
                ],
                [
                    'attribute'=>'expire', 
                    'format'=>['date', 'php:d-m-Y'], 
                    'width'=>'100px'
                ],
                'valable',
                // 'attachment',
                // 'modify_by',
                [
                    'attribute'=>'modify_by', 
                    'value'=>function ($model, $key, $index, $widget) { 
                        return $model->userName;
                    }
                ],
                // [
                //     'class'=>'kartik\grid\DataColumn',
                //     'attribute'=>'userName', 
                //     'vAlign'=>'middle',
                // ],
                // 'comments',
            ];
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $exportColumns,
                'showConfirmAlert'=>false, // true
                'target'=>GridView2::TARGET_BLANK,
                'exportConfig' => [
                    // ExportMenu::FORMAT_HTML => false,
                    // ExportMenu::FORMAT_CSV => false,
                    // GridView2::CSV => false,
                    // GridView2::PDF => false,
                    // GridView2::EXCEL => false,
                    // GridView2::HTML => false,
                ],
            ]);
            ?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?php

    $parent_id = Yii::$app->getRequest()->getQueryParam('p_id');

    if(isset($parent_id)&&strlen($parent_id)>0){
        $arr_map_subct = CertificatesTypesItems::find()
                            ->orderBy('title_'.Yii::$app->language)
                            ->where(['parent_id' => $parent_id])
                            ->asArray()
                            ->all();
    }else{
        $arr_map_subct = CertificatesTypesItems::find()
                            ->orderBy('title_'.Yii::$app->language)
                            // ->where(['parent_id' => $parent_id])
                            ->asArray()
                            ->all();
    }

    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        // [
        //     'attribute'=>'type_id', 
        //     // 'width'=>'310px',
        //     'value'=>function ($model, $key, $index, $widget) { 
        //         return $model->typeName;
        //     },
        //     'filterType'=>GridView2::FILTER_SELECT2,
        //     'filter'=>ArrayHelper::map(CertificatesTypes::find()->orderBy('title_'.Yii::$app->language)->asArray()->all(), 'id', 'title_'.Yii::$app->language), 
        //     'filterWidgetOptions'=>[
        //         'pluginOptions'=>[
        //             'allowClear'=>true
        //         ],
        //     ],
        //     'filterInputOptions'=>[
        //         'placeholder'=>'Any supplier'
        //         ],
        //     'group'=>true,  // enable grouping
        // ],
        [
            'attribute'=>'parent_id', 
            // 'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->parentName;
            },
            'filterType'=>GridView2::FILTER_SELECT2,
            'filter'=>ArrayHelper::map($arr_map_subct, 'id', 'title_'.Yii::$app->language), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>[
                'placeholder'=>'Any type'
                ],
            'group'=>true,  // enable grouping
            // 'subGroupOf'=>1 // supplier column index is the parent group
        ],
        // [
        //     'class'=>'kartik\grid\DataColumn',
        //     'attribute'=>'parent_id', 
        //     'value'=>function ($model, $key, $index) { 
        //         $cat = CertificatesTypesItems::find()->where(['id' => $model->parent_id])->one();
        //         return $cat['title'];
        //     },
        //     'group'=>true,  // enable grouping
        //     'groupedRow'=>true,  
        //     'subGroupOf'=>1 // supplier column index is the parent group
        // ],
        'title_'.Yii::$app->language,
        [
            'label' => 'Type',
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'typeName', 
            'vAlign'=>'middle',
        ],
        // 'type_id',
        [
            'attribute'=>'added', 
            'format'=>['date', 'php:d-m-Y'], 
            'width'=>'100px'
        ],
        [
            'attribute'=>'expire', 
            'format'=>['date', 'php:d-m-Y'], 
            'width'=>'100px'
        ],
        'valable',
        // 'attachment',
        // 'modify_by',
        // [
        //     'attribute'=>'modify_by', 
        //     'value'=>function ($model, $key, $index, $widget) { 
        //         return $model->userName;
        //     }
        // ],
        [
            'label' => 'Modify By',
            'class'=>'kartik\grid\DataColumn',
            'attribute'=>'userName', 
            'vAlign'=>'middle',
        ],
        // 'comments',
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'vAlign'=>'middle',
            'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([Yii::$app->controller->id.'/'.$action, 'id' => $key]); 
            },
            'viewOptions'=>['title'=>Yii::t('form', 'view'), 'data-toggle'=>'tooltip'],
            'updateOptions'=>['title'=>Yii::t('form', 'update'), 'data-toggle'=>'tooltip'],
            'deleteOptions'=>['title'=>Yii::t('form', 'delete'), 'data-toggle'=>'tooltip'], 
        ],
        // ['class' => 'kartik\grid\CheckboxColumn']
    ];
    echo GridView2::widget([
        'id' => 'wgrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'autoXlFormat'=>true,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
            ['content'=>
                '{export}'
            ],
        ],
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false, // true
            'target'=>GridView2::TARGET_BLANK,
            'downloadProgress' => 'Generating file. Please wait...',
        ],
        'exportConfig' => [
            GridView2::CSV => ['label' => 'CSV'],
            // GridView2::HTML => ['label' => 'HTML'],
            GridView2::PDF => ['label' => 'PDF'],
            GridView2::EXCEL => ['label' => 'XLS'],
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
            'type' => GridView2::TYPE_PRIMARY,
            '{pager}',
            'heading' =>false,
        ],
    ]);
    
    ?>


</div>
