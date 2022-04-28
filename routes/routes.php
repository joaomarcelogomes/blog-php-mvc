<?php

use \Source\Http\Router;

//instância de novo router
$router = new Router(URL);

require 'routes/pages.php';

require 'routes/admin.php';

//execução de respostas;
$router->run()->sendResponse();
