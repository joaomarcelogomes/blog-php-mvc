<?php

require 'vendor/autoload.php';
use \Source\Http\Router;
use \Source\Http\Response;
use \Source\Controller\Admin\LoginController;
use \Source\Controller\Public\PostController;

//rota home admin
$router->get('/admin', [
  function() {
    return new Response(200, 'admin :)');
  }
]);

//rota login
$router->get('/admin/login', [
  'middlewares' => [
    'require-admin-logout'
  ],
  function($request) {
    return new Response(200, LoginController::getLogin($request));
  }
]);

//rota login post
$router->post('/admin/login', [
  function($request) {
    return new Response(200, LoginController::setLogin($request));
  }
]);

$router->get('/admin/new_post', [
  function() {
    return new Response(200, PostController::newPost());
  }
]);

$router->post('/admin/new_post', [
  function($request) {
    return new Response(200, PostController::newPost($request));
  }
]);
