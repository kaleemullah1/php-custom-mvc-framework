<?php
namespace App;

if($_SERVER['HTTP_HOST'] == 'localhost' || strpos($_SERVER['HTTP_HOST'],'localhost') == true){
    define('APP_ENV','dev');
}else{
    define('APP_ENV' , 'prod');
}

if(APP_ENV == 'dev'){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on') {
    $url = "https://";
} else {
    $url = "http://";
}



$documnet_root = rtrim($_SERVER['DOCUMENT_ROOT'],'/');

if(APP_ENV == 'dev') {
    define('APP_URL',$url.$_SERVER['HTTP_HOST'].'/php-custom-mvc-framework');
    define('PUBLIC_URL',$url.$_SERVER['HTTP_HOST'].'/php-custom-mvc-framework/public');
    define('DIRECTORY_PATH', $_SERVER['DOCUMENT_ROOT'] . "/php-custom-mvc-framework");
}else{
    define('PUBLIC_URL',$url.$_SERVER['HTTP_HOST'].'/php-custom-mvc-framework/public');
    define('APP_URL',$url.$_SERVER['HTTP_HOST']."/php-custom-mvc-framework");
    define('DIRECTORY_PATH', $_SERVER['DOCUMENT_ROOT']."/php-custom-mvc-framework");
}

//bootstrapping app
require __DIR__.'/Bootstrap/app.php';

?>
