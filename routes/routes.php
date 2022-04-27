<?php

require 'vendor/autoload.php';

use \Source\Http\Router;
use \Source\Http\Response;
use \Source\Controller\HomeController;
use \Source\Controller\PostController;

//instância de novo router
$router = new Router(URL);

//rota home
$router->get('/', [
  function() {
    return new Response(200, HomeController::getHome());
  }
]);

//rota sobre
$router->get('/post/{id}', [
  function($id) {
    return new Response(200, PostController::getPost($id));
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
//execução de respostas;
$router->run()->sendResponse();
