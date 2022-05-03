<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Products */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('form', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('form', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('form', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cod',
            'title_en',
            'title_fr',
            // 'company_id',
            // 'certificat_id',
            // 'lot',
        ],
    ]) ?>



    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive table-widget">
                <table id="table_attach" class="table table-bordered">
                    <tr>
                        <th colspan="5"><i class="fa fa-tasks fa-fw"></i> Certificates List</th>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Expire</th>
                        <th>Action</th>
                    </tr>
                    <?php if(isset($certificates)&&is_array($certificates)){ ?>
                        <?php foreach ($certificates as $key => $license) { ?>
                            <tr data-id="<?=$license->id;?>">
                                <td>
                                    <?=$license->typeName;?>
                                </td>
                                <td>
                                    <?=$license->parentName;?>
                                </td>
                                <td>
                                    <?=$license->companyName;?>
                                </td>
                                <td>
                                    <?=$license->expire;?>
                                </td>
                                <td>
                                    <a href="<?=Url::to(['certificates/view', 'id' => $license->id]);?>" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>



</div>
