<?php
use App\Providers\Route;

try {
    //simple route
    Route::add('GET', '/', 'HomeController', 'home');

    //route with middleware
    Route::add('GET', '/test', 'HomeController', 'test');

    //route with middleware only
    Route::middleware(['web'])->group(function ($route) {
        $route->add('GET', '/middleware', 'HomeController', 'middleware');
    });

    //route with prefix only
    Route::prefix('home')->group(function ($route) {
        $route->add('GET', '/prefix', 'HomeController', 'prefix');
    });

    //route with middleware and prefix
    Route::middleware(['web'])->prefix('home')->group(function ($route) {
        $route->add('GET', '/prefix_and_middleware', 'HomeController', 'prefix_and_middleware');
    });

    //api routes
    Route::prefix('api')->middleware(['api'])->group(function ($route) {
        $route->add('post', '/get', 'ApiController', 'getAll');
    });
}catch (Exception $exception){
    Throw new Exception($exception);
}