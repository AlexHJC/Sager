<?php


use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
$this->title = Yii::$app->name;
$this->params['breadcrumbs'][] = 'Confirm new plan';
?>
<div class="subscription-confirm-new-plan">
    <div class="main-header">
        <h2>
            Change subscription package  </h2>
        <em>package</em>
        <div class="balance-title pull-right">
            <h2 style="border-right:0 none;">Account Balance : <span>
      $-69.00      </span> </h2>
        </div>

    </div>

    <div class="main-content">
        <div class="table-responsive table-widget">
                <table class="table table-bordered" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th><strong>Description</strong></th>
                        <th width="200"><strong>Quantity</strong></th>
                        <th width="150" align="right"><strong>Price</strong></th>
                        <th width="150" align="right"><strong>Amount</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td width="460">
                            <?php echo $plan->plan_title;?>
                        </td>
                        <td>1</td>
                        <td align="right"><?php echo $plan->plan_price_year ?></td>
                        <td class="totalprice" align="right"><?php echo $plan->plan_price_year;?></td>
                    </tr><tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">Total</td>
                        <td id="totalcast" align="right"><?php echo $plan->plan_price_year;?></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right"></td>
                    </tr>
                    </tbody>
                </table>
                <br>
        </div>
    </div>
