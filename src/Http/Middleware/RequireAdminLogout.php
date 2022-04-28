<?php

namespace Source\Http\Middleware;

use \Source\Utils\Session\Admin\Login;
use \Source\Http\Response;

class RequireAdminLogout {

  public static function handle($request, $next): Response {
    //verifica se o usuário está logado
    if(Login::isLogged()) {
      //redireciona para admin caso esteja logado
      $request->getRouter()->redirect('/admin');
    }
    //continua execução
    return $next($request);
  }

}
