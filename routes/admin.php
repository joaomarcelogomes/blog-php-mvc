<?php

use \Source\Http\Response;
use \Source\Controller\Admin\LoginController;
use \Source\Controller\Admin\AdminController;

//rota home admin
$router->get('/admin', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200, AdminController::getHomeAdmin());
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
    return new Response(200, AdminController::createPost());
  }
]);

//rota post de criação de postagem
$router->post('/admin/new_post', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, AdminController::createPost($request));
  }
]);

//rota get de alteração de postagem
$router->get('/admin/edit_post/{id}', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($id) {
    return new Response(200, AdminController::updatePost($id));
  }
]);

//rota post de alteração de postagem
$router->post('/admin/edit_post/{id}', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($id, $request) {
    return new Response(200, AdminController::updatePost($id, $request));
  }
]);

//rota get de remoção de postagem
$router->get('/admin/delete_post/{id}', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($id) {
    return new Response(200, AdminController::deletePost($id));
  }
]);

//rota post de remoção de postagem
$router->post('/admin/delete_post/{id}', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($id, $request) {
    return new Response(200, AdminController::deletePost($id, $request));
  }
]);

//rota get de criação de postagem
$router->get('/admin/new_user', [
  'middlewares' => [
    'required-admin-login'
  ],
  function() {
    return new Response(200, AdminController::createAdmin());
  }
]);

//rota post de criação de postagem
$router->post('/admin/new_user', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, AdminController::createAdmin($request));
  }
]);
