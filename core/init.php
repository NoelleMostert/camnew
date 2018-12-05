<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root123', // come back here
        'db' => 'camagru'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800 // 7 days, in seconds
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

/* 
auto-loading classes
Structured dynamically using anonymous functions and
protecting against file name / directory changes
#DEF: SPL = Standard PHP Library
*/ 

spl_autoload_register(function($class) {
include_once 'classes/' . $class . '.php';
});


include_once 'functions/sanitize.php';

//remember me functionality

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('user_sessions', array('hash', '=', $hash));

    if ($hashCheck->count()) {
        $user = new User ($hashCheck->first()->user_id);
        $user->login();
    }
}
?>