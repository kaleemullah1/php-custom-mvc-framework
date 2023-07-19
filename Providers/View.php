<?php

namespace App\Providers;

class View
{
    private static $view_path = 'View';
    private static $ui = 'global';
    public static $data= [];
    public function __construct()
    {
    }

    public static function load($view,$data){
        self::$data = $data;
        $view_path = self::$view_path.'/'.$view.'.php';
        if(file_exists($view_path)){
            self::$data['content'] = $view_path;
        }else{
            throw new \Exception('View '.$view_path.' not found!');
        }

        self::setupglobalUI();
    }

    private static function setupGlobalUI(){
        $global_partial = self::$view_path.'/partials/'.self::$ui.'.php';
        if(file_exists($global_partial)){
            require $global_partial;
        }else{
            throw new \Exception('View '.$global_partial.' not found!');
        }
    }

    public static function setupUI($ui){
        self::$ui = $ui;
    }

}