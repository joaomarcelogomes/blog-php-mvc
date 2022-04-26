<?php

require 'vendor/autoload.php';

use \Source\Http\Router;
use \Source\Http\Response;

$req = new Router('http://localhost:8080');

$req->get('/', [
  function() {
    return new Response(200, 'OK');
  }
]);

$req->run()->sendResponse();
