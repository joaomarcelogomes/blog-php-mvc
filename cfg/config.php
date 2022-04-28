<?php

require 'vendor/autoload.php';
use \Source\Http\Middleware\MiddlewareQueue;

define('URL', 'http://localhost:8080');

MiddlewareQueue::setMap([
  'required-admin-logout' => \Source\Http\Middleware\RequireAdminLogout::class,
  'required-admin-login' => \Source\Http\Middleware\RequireAdminLogin::class,
]);
