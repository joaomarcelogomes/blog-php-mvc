<?php

namespace Source\Http\Middleware;

use \Source\Utils\Session\Admin\Login;
use \Source\Http\Response;

/**
 * classe de middleware de autenticação de admin
 */
class RequireAdminLogin {

  /**
   * método comum de todos os middlewares
   * @param  Request   $request
   * @param  Response   $next
   * @return Response
   */
  public static function handle($request, $next): Response {
    //verifica se o usuário está logado
    if(!Login::isLogged()) {
      //redireciona para a página de login caso não esteja logado
      $request->getRouter()->redirect('/admin/login');
    }
    //continua a execução
    return $next($request);
  }

}
