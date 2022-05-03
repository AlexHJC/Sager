<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var string $maintenanceText
 * @var int|string $retryAfter
 */

use frontend\models\Settings;

?>
<div id="maintenance-content" style="margin-top: 10%">
    <p class="well">
        <?php

        $oSettings = new Settings();

        echo Yii::t('common', $maintenanceText, [
            'retryAfter' => $retryAfter,
            'adminEmail' => $oSettings->getSetting('adminEmail')
        ]) ?>
    </p>
</div>