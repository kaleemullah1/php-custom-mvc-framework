<?php
namespace App\Controllers;

use App\Classes\SessionManager;

class Controller
{
    public $data;
    public $session;

    function __construct(){
        $this->data['session'] = new SessionManager();
        $this->session = $this->data['session'];
    }

}