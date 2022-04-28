<?php

require 'vendor/autoload.php';

use \Source\Http\Router;
use \Source\Http\Response;
use \Source\Controller\Public\HomeController;
use \Source\Controller\Public\PostController;
//
// //instância de novo router
// $router = new Router(URL);

//rota home
$router->get('/', [
  function($request) {
    return new Response(200, HomeController::getHome($request));
  }
]);

//rota sobre
$router->get('/post/{id}', [
  function($id) {
    return new Response(200, PostController::getPost($id));
  }
]);
