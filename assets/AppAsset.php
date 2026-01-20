<?php
namespace app\assets;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
 
    public $css = [
        'css/sidebar-menu.css',
        'css/simplebar.css',
        'css/apexcharts.css',
        'css/prism.css',
        'css/rangeslider.css',
        'css/sweetalert.min.css',
        'css/quill.snow.css',
        'css/google-icon.css',
        'css/remixicon.css',
        'css/swiper-bundle.min.css',
        'css/fullcalendar.main.css',
        'css/jsvectormap.min.css',
        'css/lightpick.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
        'css/style.css', 
    ];
    
    public $js = [
        'js/simplebar.min.js',
        'js/feather.min.js',
        'js/moment.min.js',
        'js/lightpick.js',
        'js/clipboard.min.js',
        'js/prism.js',
        'js/quill.min.js',
        'js/rangeslider.min.js',
        // 'js/sweetalert.js', 
        'https://cdn.jsdelivr.net/npm/sweetalert2@11', 
        
        'js/sidebar-menu.js', 
        'js/dragdrop.js',
        
        'js/apexcharts.min.js',
        'js/echarts.js',
        'js/swiper-bundle.min.js',
        'js/fullcalendar.main.js',
        'js/jsvectormap.min.js',
        'js/world-merc.js',
        'js/data-table.js',
        
        'js/custom/apexcharts.js',
        'js/custom/echarts.js',
        'js/custom/custom.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset', 
    ];
}