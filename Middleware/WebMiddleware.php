<?php
namespace App\Middleware;

use App\Classes\Response;
use App\Classes\SessionManager;

class WebMiddleware implements Middleware
{
    public function handle()
    {
        /*$session_manager = new SessionManager();
        $user = $session_manager->get('user');
        if(empty($user)){
            Response::redirect('login');
        }*/
    }

}