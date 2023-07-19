<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Classes\Request;
use App\Classes\Response;

class HomeController extends Controller
{
    public function home(){
        $data = ['greetings' => "Welcome"];
        return Response::view('home' , $data);
    }

    public function test(){
        $data = ['greetings' => "This is just a test!"];
        return Response::view('home' , $data);
    }

    public function prefix_and_middleware(){
        $data = ['greetings' => "This is group route example with prefix and middleware"];
        return Response::view('home' , $data);
    }
    public function prefix(){
        $data = ['greetings' => "This is group route example with prefix only"];
        return Response::view('home' , $data);
    }

    public function middleware(){
        $data = ['greetings' => "This is group route example with middleware only"];
        return Response::view('home' , $data);
    }
}