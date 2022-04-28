<?php

use \Source\Http\Response;
use \Source\Controller\Public\HomeController;
use \Source\Controller\Public\PostController;

//rota home
$router->get('/', [
  function($request) {
    return new Response(200, HomeController::getHome($request));
  }
]);

//rota de artigo
$router->get('/post/{id}', [
  function($id) {
    return new Response(200, PostController::getPost($id));
  }
]);
