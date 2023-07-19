<?php

namespace App\Middleware;

use App\Classes\Request;
use App\Classes\Response;

class ApiMiddleware implements Middleware
{

    public function handle()
    {
        $basic_user = Request::getServerProp('PHP_AUTH_USER');
        $basic_pwd = Request::getServerProp('PHP_AUTH_PW');

        $auth = getBasicAuth();
        if(!empty($auth[$basic_user]) && $auth[$basic_user] == $basic_pwd){
            // request is valid
        }else{
            $data = ['code'=>401,'message'=>'Not authorized!','status'=>false];
            echo Response::json($data);
            exit();
        }
    }
}