<?php
namespace App\Providers;

use App\Classes\Request;
use App\Classes\Response;

global $routes;

class Route
{
    public $middleware = [];
    public $prefix = '';

    public function __call($method,$args){
        return $this->call($method, $args);
    }

    public static function __callStatic($method,$args){
        return (new Route())->call($method,$args);
    }

    private function call($method, $args)
    {
        $method .= 'Action';
        if (! method_exists($this , $method)) {
            throw new \Exception('Call undefined method ' . $method);
        }

        return $this->{$method}(...$args);
    }

    private function addRoute($route,$controller,$action,$type){
        $route = empty($route)?'default':$route;
        if(!empty($this->prefix)){
            $route = $this->getRouteWithPrefix($route);
        }
        $GLOBALS['routes'][$route] = ['controller'=>$controller,'action'=>$action,'type'=>$type,'middleware'=>$this->middleware];
    }
    private function getRouteWithPrefix($route){
        $route = $this->stripeSlash($route);
        if(!empty($this->prefix)){
            $route = !empty($route) ? $this->prefix.'/'.$route : $this->prefix;
        }
        return $route;
    }

    public function prefixAction($name){
        $this->prefix = $name;
        return $this;
    }

    public function middlewareAction(array $names){
        $this->middleware = $names;
        return $this;
    }

    public function getAllAction(){
        return $GLOBALS['routes'];
    }

    public function matchAction(){
        try {
            $path = Request::getServerProp('PATH_INFO');
            $path = $this->stripeSlash($path);
            $path = empty($path)?'default':$path;
            return $this->validateRequestPath($path);
        }catch (\Exception $exception){
           return $exception->getMessage();
        }

    }

    public function addAction($type , $route, $controller, $action){
        $route = $this->stripeSlash($route);
        $this->addRoute($route,$controller,$action,strtolower($type));
        return $this;
    }

    public function stripeSlash($route){
        if(substr($route,0,1) == '/'){
            return substr($route,1);
        }else{
            return $route;
        }
    }
    private function getRouteDetail($path){
        if(!empty($GLOBALS['routes'][$path])){
            return $GLOBALS['routes'][$path];
        }
        return false;
    }

    private function validateRequestPath($path){
        try {
            $detail = $this->getRouteDetail($path);
            if (!empty($detail)) {
                $controller = $detail['controller'];
                $action = $detail['action'];
                $type = $detail['type'];
                $middleware = $detail['middleware'];

                if(!empty($middleware)){
                    foreach ($middleware as $m) {
                        $middleware_name = ucfirst($m) . 'Middleware';
                        $middleware_path = "\App\Middleware\\$middleware_name";
                        $middlewareObj = new $middleware_path();
                        $res = $middlewareObj->handle();
                    }
                }
                $request_type = Request::getServerProp('REQUEST_METHOD');
                if ($type !== strtolower($request_type)) {
                    return Response::view('errors/method_not_allowed');
                }
                $controller_path = "\App\Controllers\\$controller";
                $controllerObj = new $controller_path();
                return $controllerObj->$action();
            } else {
                return Response::view('errors/not_found');
            }
        }catch (\Exception $exception){
            $data = ['message' => $exception->getMessage(),'trace' => $exception->getTrace()];
            return Response::view('errors/error',$data);
        }

    }

    public function group(\Closure $route){
        $route($this);
    }

}

/*class PrefixRoute{
    public static $prefix;

    public function group(\Closure $route){
        $route($this);
    }

    public function middleware(array $names){
        $middlewareObj = new MiddlewareRoute();
        $middlewareObj::$middleware = $names;
        return $middlewareObj;
    }

    public static function get($route, $controller, $action,$middleware=null){
        $route = self::getRouteWithPrefix($route);
        Route::get($route,$controller,$action,$middleware);
    }

    public static function post($route, $controller, $action,$middleware=null){
        $route = self::getRouteWithPrefix($route);
        Route::post($route,$controller,$action,$middleware);
    }

    private static function getRouteWithPrefix($route){
        $route = Route::stripeSlash($route);
        if(!empty(self::$prefix)){
            $route = !empty($route)?self::$prefix.'/'.$route:self::$prefix;
        }
        return $route;
    }

}

class MiddlewareRoute{
    public static $middleware;

    public function group(\Closure $route){
        $route($this);
    }

    public function prefix($name){
        $prefixObj = new PrefixRoute();
        $prefixObj::$prefix = $name;
        return new self();
    }

    public static function get($route, $controller, $action){
        PrefixRoute::get($route,$controller,$action,self::$middleware);
    }

    public static function post($route, $controller, $action){
        PrefixRoute::post($route,$controller,$action,self::$middleware);
    }

}*/