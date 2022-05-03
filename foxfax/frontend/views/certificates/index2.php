<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
// use yii\widgets\Pjax;
use kartik\grid\GridView;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CertificatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('form', 'Certificates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-index">
    <div class="row">





        <div class="col-md-2 export_config_sp text-right">
            <?php
            
            $exportColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                'id',
                [
                    'attribute'=>'type_id', 
                    // 'width'=>'310px',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return $model->typeName;
                    },
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map(CertificatesTypes::find()->orderBy('title_'.Yii::$app->language)->asArray()->all(), 'id', 'title_'.Yii::$app->language), 
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Any supplier'],
                    'group'=>true,  // enable grouping
                ],
                [
                    'attribute'=>'parent_id', 
                    // 'width'=>'250px',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return $model->parentName;
                    },
                    'filterType'=>GridView::FILTER_SELECT2,
                    // 'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Any category'],
                    'group'=>true,  // enable grouping
                    'subGroupOf'=>1 // supplier column index is the parent group
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
                    'class'=>'kartik\grid\DataColumn',
                    'attribute'=>'userName', 
                    'vAlign'=>'middle',
                ],
                // 'comments',
            ];
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $exportColumns,
                'showConfirmAlert'=>false, // true
                'target'=>GridView::TARGET_BLANK,
                'exportConfig' => [
                    // ExportMenu::FORMAT_HTML => false,
                    // ExportMenu::FORMAT_CSV => false,
                    // GridView::CSV => false,
                    // GridView::PDF => false,
                    // GridView::EXCEL => false,
                    // GridView::HTML => false,
                ],
            ]);
            ?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php
        
        // $models = $dataProvider->getModels();
        // foreach ($models as $key => $rec) {
        //     echo '<br>_______________________________________<br>';
        //     echo $rec->id.' - ';
        //     echo $rec->title.' - ';
        //     echo 'Subcat: '.$rec->parent_id.' '.$rec->parentName.' - ';
        //     echo 'Cat: '.$rec->type_id.' '.$rec->typeName;
        //     echo '<br>_______________________________________<br>';
        // }
    ?>

    <?php /*
    <?php $this->widget('CLinkPager', array(
        'pages' => $dataProvider->pagination,
    )); ?>  
    */ ?>
    
    <?php /*
    <div id="wgrid-pjax" data-pjax-container="" data-pjax-push-state="" data-pjax-timeout="1000">
        <div id="wgrid" class="grid-view" data-krajee-grid="kvGridInit_6bec5cab">
            <div class="panel panel-primary">
                <div class="kv-panel-before">
                    <div class="pull-left">
                        <form action="/en/certificates/index" method="get">
                            <input type="hidden" name="CertificatesSearch[title_en]" value="Legume">
                            <input type="hidden" name="_pjax" value="#wgrid-pjax">
                            <label class="cl001">
                                Show 
                                <select class="form-control input-sm" name="cw" onchange="this.form.submit()">
                                    <option value="10" selected="">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="0">All</option>
                                </select>
                                entries
                            </label>
                        </form>
                    </div>
                    <div class="pull-right">
                        <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
                            <div class="btn-group">
                                <div id="wgrid-filters" class="filters skip-export"> 
                                <span>Search:&nbsp;<input type="text" class="form-control" name="CertificatesSearch[title_en]" value="Legume">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                <a class="btn btn-default refresh_ntn_gr" href="/en/certificates/#" title="Reset Grid" data-pjax="0" onclick="$.pjax.reload({container:'#wgrid-pjax'});"><i class="glyphicon glyphicon-repeat"></i></a> 
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="wgrid-container" class="table-responsive kv-grid-container" style="overflow: auto">
                    <table class="kv-grid-table table table-hover kv-table-wrap">
                        <thead>
                            <tr>
                                <th class="kv-align-center kv-align-middle kv-merged-header" style="width: 5.43%;" rowspan="2" data-col-seq="0">#</th>
                                <th data-col-seq="2" style="width: 37.24%;"><a href="/en/certificates/index?CertificatesSearch%5Btitle_en%5D=Legume&amp;_pjax=%23wgrid-pjax&amp;sort=title_en" data-sort="title_en">Title EN</a></th>
                                <th class="kv-align-middle" data-col-seq="3" style="width: 8.25%;"><a href="/en/certificates/index?CertificatesSearch%5Btitle_en%5D=Legume&amp;_pjax=%23wgrid-pjax&amp;sort=typeName" data-sort="typeName">Type</a></th>
                                <th style="width: 10.86%;" data-col-seq="4"><a href="/en/certificates/index?CertificatesSearch%5Btitle_en%5D=Legume&amp;_pjax=%23wgrid-pjax&amp;sort=added" data-sort="added">Added Date</a></th>
                                <th style="width: 10.86%;" data-col-seq="5"><a href="/en/certificates/index?CertificatesSearch%5Btitle_en%5D=Legume&amp;_pjax=%23wgrid-pjax&amp;sort=expire" data-sort="expire">Expir. Date</a></th>
                                <th data-col-seq="6" style="width: 8.03%;"><a href="/en/certificates/index?CertificatesSearch%5Btitle_en%5D=Legume&amp;_pjax=%23wgrid-pjax&amp;sort=valable" data-sort="valable">Valable</a></th>
                                <th class="kv-align-middle" data-col-seq="7" style="width: 10.86%;"><a href="/en/certificates/index?CertificatesSearch%5Btitle_en%5D=Legume&amp;_pjax=%23wgrid-pjax&amp;sort=userName" data-sort="userName">Modify By</a></th>
                                <th class="kv-align-center kv-align-middle skip-export kv-merged-header" style="width: 8.47%;" rowspan="2" data-col-seq="8">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="kv-grid-group-row">
                                <td class="kv-grid-group kv-group-even" data-col-seq="1" data-group-key="d82b34cd" data-odd-css="kv-group-odd" data-even-css="kv-group-even" data-grouped-row="" style="width: auto;" data-cell-key="Legume" colspan="8">Legume</td>
                            </tr>
                            <tr data-key="1">
                                <td class="kv-align-center kv-align-middle" style="width: 50px; mso-number-format: &quot;\@&quot;;" data-col-seq="0">1</td>
                                <td data-col-seq="2" style="mso-number-format: &quot;\@&quot;;">YUPIK 1KG - BLANCHED PEANUTS RS</td>
                                <td class="kv-align-middle" data-col-seq="3" style="mso-number-format: &quot;\@&quot;;">Legume</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="4" data-raw-value="2017-01-17">17-01-2017</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="5" data-raw-value="2017-02-23">23-02-2017</td>
                                <td data-col-seq="6" style="mso-number-format: &quot;\@&quot;;">yes</td>
                                <td class="kv-align-middle" data-col-seq="7" style="mso-number-format: &quot;\@&quot;;">admin</td>
                                <td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="8"><a href="/en/certificates/view?id=1" title="view" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="/en/certificates/update?id=1" title="update" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a> <a href="/en/certificates/delete?id=1" title="delete" data-confirm="Are you sure to delete this item?" data-method="post" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>
                            <tr data-key="4">
                                <td class="kv-align-center kv-align-middle" style="width: 50px; mso-number-format: &quot;\@&quot;;" data-col-seq="0">2</td>
                                <td data-col-seq="2" style="mso-number-format: &quot;\@&quot;;">MTCN</td>
                                <td class="kv-align-middle" data-col-seq="3" style="mso-number-format: &quot;\@&quot;;">Legume</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="4" data-raw-value="2017-01-14">14-01-2017</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="5" data-raw-value="2017-03-15">15-03-2017</td>
                                <td data-col-seq="6" style="mso-number-format: &quot;\@&quot;;">yes</td>
                                <td class="kv-align-middle" data-col-seq="7" style="mso-number-format: &quot;\@&quot;;">admin</td>
                                <td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="8"><a href="/en/certificates/view?id=4" title="view" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="/en/certificates/update?id=4" title="update" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a> <a href="/en/certificates/delete?id=4" title="delete" data-confirm="Are you sure to delete this item?" data-method="post" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>
                            <tr data-key="6">
                                <td class="kv-align-center kv-align-middle" style="width: 50px; mso-number-format: &quot;\@&quot;;" data-col-seq="0">3</td>
                                <td data-col-seq="2" style="mso-number-format: &quot;\@&quot;;">BLACK &amp; WHITE CHIA SEEDS MIX</td>
                                <td class="kv-align-middle" data-col-seq="3" style="mso-number-format: &quot;\@&quot;;">Legume</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="4" data-raw-value="2017-01-24">24-01-2017</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="5" data-raw-value="<span class=&quot;not-set&quot;>(not set)</span>"><span class="not-set">(not set)</span></td>
                                <td data-col-seq="6" style="mso-number-format: &quot;\@&quot;;">yes</td>
                                <td class="kv-align-middle" data-col-seq="7" style="mso-number-format: &quot;\@&quot;;">admin</td>
                                <td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="8"><a href="/en/certificates/view?id=6" title="view" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="/en/certificates/update?id=6" title="update" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a> <a href="/en/certificates/delete?id=6" title="delete" data-confirm="Are you sure to delete this item?" data-method="post" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>
                            <tr data-key="7">
                                <td class="kv-align-center kv-align-middle" style="width: 50px; mso-number-format: &quot;\@&quot;;" data-col-seq="0">4</td>
                                <td data-col-seq="2" style="mso-number-format: &quot;\@&quot;;">YUPIK 1KG - WHOLE CASHEWS RNS</td>
                                <td class="kv-align-middle" data-col-seq="3" style="mso-number-format: &quot;\@&quot;;">Legume</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="4" data-raw-value="2017-01-24">24-01-2017</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="5" data-raw-value="2016-12-29">29-12-2016</td>
                                <td data-col-seq="6" style="mso-number-format: &quot;\@&quot;;">yes</td>
                                <td class="kv-align-middle" data-col-seq="7" style="mso-number-format: &quot;\@&quot;;">admin</td>
                                <td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="8"><a href="/en/certificates/view?id=7" title="view" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="/en/certificates/update?id=7" title="update" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a> <a href="/en/certificates/delete?id=7" title="delete" data-confirm="Are you sure to delete this item?" data-method="post" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>
                            <tr data-key="8" data-last-row="1">
                                <td class="kv-align-center kv-align-middle" style="width: 50px; mso-number-format: &quot;\@&quot;;" data-col-seq="0">5</td>
                                <td data-col-seq="2" style="mso-number-format: &quot;\@&quot;;">YUPIK 1KG - BLANCHED PEANUTS RNS</td>
                                <td class="kv-align-middle" data-col-seq="3" style="mso-number-format: &quot;\@&quot;;">Legume</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="4" data-raw-value="2017-01-25">25-01-2017</td>
                                <td style="width: 100px; mso-number-format: &quot;Short Date&quot;;" data-col-seq="5" data-raw-value="2017-01-26">26-01-2017</td>
                                <td data-col-seq="6" style="mso-number-format: &quot;\@&quot;;">yes</td>
                                <td class="kv-align-middle" data-col-seq="7" style="mso-number-format: &quot;\@&quot;;">admin</td>
                                <td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="8"><a href="/en/certificates/view?id=8" title="view" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="/en/certificates/update?id=8" title="update" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-pencil"></span></a> <a href="/en/certificates/delete?id=8" title="delete" data-confirm="Are you sure to delete this item?" data-method="post" data-pjax="0" data-toggle="tooltip"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="kv-panel-after"></div>
                <div class="panel-footer">
                    <div class="kv-panel-pager">
                        <div class="summary">Showing <b>1-5</b> of <b>5</b> items.</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    */ ?>


    <?php

    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute'=>'type_id', 
            // 'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->typeName;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(CertificatesTypes::find()->orderBy('title_'.Yii::$app->language)->asArray()->all(), 'id', 'title_'.Yii::$app->language), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
        ],
        [
            'attribute'=>'parent_id', 
            // 'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->parentName;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            // 'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any category'],
            'group'=>true,  // enable grouping
            'subGroupOf'=>1 // supplier column index is the parent group
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
        'title_en',
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
    echo GridView::widget([
        'id' => 'wgrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'autoXlFormat'=>true,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
            ['content'=>
                // Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                // '{range}'.' '.
                '{search}'.' '.
                '{export}'.' '.
                '{refresh}'. ' '
            ],
        ],
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false, // true
            'target'=>GridView::TARGET_BLANK,
            'downloadProgress' => 'Generating file. Please wait...',
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

    <?php /*
    <?php Pjax::begin(); ?>    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],
                'id',
                'title',
                [
                    'attribute' => 'Type',
                    'value' => 'type.title'
                ],
                // 'type_id',
                'added',
                'expire',
                'valable',
                // 'attachment',
                // 'modify_by',
                // 'comments',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
    */ ?>

</div>
