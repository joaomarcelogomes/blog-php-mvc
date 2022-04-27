<?php

namespace Source\Http\Middleware;

use \Source\Utils\Session\Admin\Login;

class RequireAdminLogout {

  public static function handle($request, $next): Response {
    if(Login::isLogged()) {
      die('está logado');
    }
    die('não está logado');
  }

}
