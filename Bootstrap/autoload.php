<?php
/*
 * Classes needs to autoload
 * */


spl_autoload_register(function ($class_name) {
    if (strpos($class_name, '/') == true) {
        $directory = explode("/", $class_name);
        $count = count($directory);
        $dir_name = '';
        if (!empty($directory)) {
            for ($i = 0; $i < $count; $i++) {
                $dir_name .= empty($dir_name) ? $directory[$i] : '/' . $directory[$i];
            }
        }
        if (!empty($dir_name)) {
            $file_name = $dir_name.'.php';
            if(file_exists($file_name)) {
                require_once $file_name;
            }else{
                throw new \Exception($file_name.' does not exist!');
            }
        }
    } else {
        $directory = explode("\\", $class_name);
        $count = count($directory);
        $dir_name = '';

        if (!empty($directory)) {
            for ($i = 1; $i < $count; $i++) {
                $dir_name .= empty($dir_name) ? $directory[$i] : '/' . $directory[$i];
            }
        }
        if (!empty($dir_name)) {
            $file_name = $dir_name.'.php';
            if(file_exists($file_name)) {
                require_once $file_name;
            }else{
                throw new \Exception($file_name.' does not exist!');
            }
        }
    }
});

require_once 'Controllers/Controller.php';

//load app configs
require 'Config/config.php';
require 'Config/auth.php';

require 'Classes/Request.php';
require 'Classes/Response.php';

//load app routes
require 'Providers/Route.php';
require 'Routes/routes.php';

session_start();

function dd($data){
    echo "<pre>";
    print_r($data);
    exit();
}
?>