<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\i18n\models\I18nSourceMessage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'I18n Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-source-message-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category',
            'message:ntext',
        ],
    ]) ?>


    <hr>

    <div>
        <table id="w0" class="table table-striped table-bordered detail-view">
            <tbody>
                <tr>
                    <th>Language</th>
                    <th>Translation</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($mesages as $key => $message) { ?>
                    <tr>
                        <th><?=$message->language;?></th>
                        <td><?=$message->translation;?></td>
                        <td>
                            <a href="<?=Yii::$app->urlManager->createUrl(['admin/i18n/i18n-message/update', array('id' => $message->id, 'language' => $message->language)]);?>" target="_blank">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
