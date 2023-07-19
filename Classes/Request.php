<?php

namespace App\Classes;

use App\Providers\Route;

class Request
{
    public static $request;
    public static $get;
    public static $post;
    public static $files;
    public static $server;
    public static $headers;

    public static function send(){
        self::initialize();
        return Route::match();
    }

    public static function initialize(){
        self::$get = $_GET;
        self::$post = $_POST;
        self::$request = $_REQUEST;
        self::$files = $_FILES;
        self::$server = $_SERVER;
        self::$headers = getallheaders();
    }

    public static function get($variable){
        if(isset(self::$request[$variable])){
            return self::$request[$variable];
        }elseif(isset(self::$get[$variable])){
            return self::$get[$variable];
        }elseif(isset(self::$post[$variable])){
            return self::$post[$variable];
        }else{
            return '';
        }
    }

    public static function getServerProp($variable){
        if(isset(self::$server[$variable])){
            return self::$server[$variable];
        }
        return '';
    }

    public static function getHeader($header){
        if(isset(self::$headers[$header])){
            return self::$headers[$header];
        }
        return '';
    }
}