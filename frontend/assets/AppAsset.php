<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'assets/nw/css/bootstrap.min.css',
        'assets/nw/css/animate.css',
        'assets/nw/css/nivo-lightbox.css',
        'assets/nw/css/own.theme.css',
        'assets/nw/css/slick.css',
        'assets/nw/css/main.css',
        'assets/nw/img/team/',
        'assets/nw/css/owt.carousel.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
