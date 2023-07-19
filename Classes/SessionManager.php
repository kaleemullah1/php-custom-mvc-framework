<?php

namespace App\Classes;

class SessionManager
{
    public $namespace;
    public $session;

    public function __construct($namespace=null){
        $this->namespace = $namespace;
        $this->session = $_SESSION;
    }

    public function getAll($namespace=null){
        if(!empty($this->namespace)){
            $session = !empty($this->session[$this->namespace])?$this->session[$this->namespace]:array();
        }elseif(!empty($namespace)){
            $session = !empty($this->session[$namespace])?$this->session[$namespace]:array();
        }else{
            $session = $this->session;
        }
        return $session;
    }
    
    public function get($prop,$namespace=null){
        if(!empty($namespace)){
            return isset($this->session[$namespace][$prop])?$this->session[$namespace][$prop]:'';
        }elseif(!empty($this->namespace)){
            return isset($this->session[$namespace][$prop])?$this->session[$namespace][$prop]:'';
        }else{
            return isset($this->session[$prop])?$this->session[$prop]:'';
        }
    }

    public function set($key,$value,$namespace=null){
        if(!empty($namespace)){
            $_SESSION[$namespace][$key] = $value;
        }elseif (!empty($this->namespace)){
            $_SESSION[$this->namespace][$key] = $value;
        }else {
            $_SESSION[$key] = $value;
        }
        $this->session = $_SESSION;
    }

    public function unsetProperty($key,$namespace=null){
        if(!empty($namespace)){
            unset($_SESSION[$namespace][$key]);
        }elseif (!empty($this->namespace)){
            unset($_SESSION[$this->namespace][$key]);
        }else {
            unset($_SESSION[$key]);
        }
        $this->session = $_SESSION;
    }

}