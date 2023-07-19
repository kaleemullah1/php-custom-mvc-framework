<?php
function getConfigs(){
    $configs = array(

    );

    if(APP_ENV == 'dev'){
        //dev configs goes here
        $configs['database'] = array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => '',
            'database' => 'test'
        );
    }else if(APP_ENV == 'prod'){
        //prod configs go here
    }

    return $configs;
}