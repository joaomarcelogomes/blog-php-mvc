<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

use \Source\Http\Middleware\MiddlewareQueue;

define('URL', 'http://localhost:8080');

MiddlewareQueue::setMap([
  'required-admin-logout' => \Source\Http\Middleware\RequireAdminLogout::class,
  'required-admin-login' => \Source\Http\Middleware\RequireAdminLogin::class,
]);
