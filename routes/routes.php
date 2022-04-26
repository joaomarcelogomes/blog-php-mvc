<?php

require 'vendor/autoload.php';

use \Source\Http\Router;
use \Source\Http\Response;
use \Source\Controller\HomeController;

//instância de novo router
$router = new Router(URL);

//rota home
$router->get('/', [
  function() {
    return new Response(200, HomeController::getHome());
  }
]);

//rota sobre
$router->get('/sobre', [
  function() {
    return new Response(200, 'sobre');
  }
]);

//execução de respostas;
$router->run()->sendResponse();
