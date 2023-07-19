<?php

namespace App\Classes;

use App\Providers\View;

class Response
{
    public static function view($view, array $data=[]){
        return View::load($view,$data);
    }

    public static function json(array $data){
        if(isset($data['code']) && $data['code'] !== '200'){
            http_response_code($data['code']);
        }else{
            http_response_code(200);
        }
        return json_encode($data);
    }

    public static function setupUI(){
        return View::setupUI();
    }

    public static function redirect($url){
        header('Location: '.APP_URL.'/'.$url);
    }

    public static function redirectBack(){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}