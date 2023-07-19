<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Classes\Request;
use App\Classes\Response;

class ApiController extends Controller
{
    public function getAll(){
        $data = ['greetings' => "Welcome"];
        return Response::json($data);
    }
}