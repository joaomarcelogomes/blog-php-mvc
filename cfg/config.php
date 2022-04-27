<?php

require 'vendor/autoload.php';

use \Source\Http\Middleware\MiddlewareQueue;

MiddlewareQueue::setMap([
  'require-admin-logout' => \Source\Http\Middleware\RequireAdminLogout::class
]);

define('URL', 'http://localhost:8080');
