<?php

require 'vendor/autoload.php';
use \Source\Http\Router;
use \Source\Http\Response;
use \Source\Controller\Admin\LoginController;
use \Source\Controller\Public\PostController;

//rota home admin
$router->get('/admin', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200, 'admin :)');
  }
]);

//rota get de login
$router->get('/admin/login', [
  'middlewares' => [
    'required-admin-logout'
  ],
  function($request) {
    return new Response(200, LoginController::getLogin($request));
  }
]);


//rota post de login
$router->post('/admin/login', [
  'middlewares' => [
    'required-admin-logout'
  ],
  function($request) {
    return new Response(200, LoginController::setLogin($request));
  }
]);

//rota logout
$router->get('/admin/logout', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, LoginController::setLogout($request));
  }
]);

//rota get de criação de postagem
$router->get('/admin/new_post', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200, PostController::newPost());
  }
]);

//rota post de criação de postagem
$router->post('/admin/new_post', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, PostController::newPost($request));
  }
]);
