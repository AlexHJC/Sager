<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'css/font-awesome.min.css',
        'css/bootstrap-backend.css',
        'css/datepicker.css',
        'css/dataTables.bootstrap.css',
        'css/buttons.dataTables.min.css',
        'css/chart-styles.css',
        'css/AdminLTE.css',
        'css/style.css',
    ];

    public $js = [
        'js/bootstrap.min.js',
        'js/king-chart-stat.js',
        'js/jquery.flot.min.js',
        'js/jquery.flot.resize.min.js',
        'js/jquery.flot.time.min.js',
        'js/jquery.flot.pie.min.js',
        'js/jquery.sparkline.min.js',
        'js/jquery.flot.tooltip.min.js',
        'js/bootstrap-datepicker.js',
        'js/jquery.validate.min.js',
        'js/dashboard-script.js',
        // 'js/fullcalendar.js',
        'js/jconfirmaction.jquery.js',
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap.js',
        'js/jscolor.js',
        'js/print-script.js',
        'js/script.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\Html5shiv',
    ];
}
