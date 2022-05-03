<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Certificates */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-view">

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
            'productName',
            'companyName',
            'parentName',
            'typeName',
            'userName',
            // 'type_id',
            'added',
            'expire',
            'valable',
            // 'attachment',
            // 'modify_by',
            'comments',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive table-widget">
                <table id="table_attach" class="table table-bordered">
                    <tr>
                        <th><i class="fa fa-tasks fa-fw"></i> Files List</th>
                    </tr>
                    <?php if(isset($attachments)&&is_array($attachments)){ ?>
                        <?php foreach ($attachments as $key => $file) { ?>
                            <tr data-id="<?=$file->id;?>">
                                <td>
                                    <a href="<?=$file->file;?>" target="_blank"><?=$file->file;?></a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</div>
