<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('rsa','User\UserController@rsa');
$router->post('pub','User\LoginController@pub');
$router->post('register','User\LoginController@register');
$router->get('kuayuDo','User\LoginController@kuayuDo');
$router->get('a','User\LoginController@a');

$router->post('login','User\LoginController@login');
//
//$router->group(['middleware' => 'LoginMiddleware'], function () use ($router) {
//    $router->post('checkLogin',['uses'=>'LoginMiddleware@checkLogin']);
//
//});


$router->group(['middleware' => 'login'], function () use ($router) {
    $router->post('checkLogin','User\LoginController@checkLogin');
});


