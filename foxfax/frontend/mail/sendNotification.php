<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $token string */

// $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/sign-in/reset-password', 'token' => $token]);
?>
<?php /*

Hello <?php echo Html::encode($user) ?>,

Acesta e un mesaj informativ

<?php echo Html::a(Html::encode($resetLink), $resetLink) ?>
*/ ?>

<?php
echo $emailText;
?>