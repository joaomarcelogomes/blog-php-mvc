<?php

namespace Source\Controller\Admin;

use \Source\UI\View;
use \Source\Service\AdminService;
use \Source\Utils\Session\Admin\Login;
use \Source\Model\Admin;
use \Source\Http\Request;

/**
 * classe responsável por controlar o login de admin
 */
class LoginController extends PageController {

  /**
   * método responsável por instanciar o service e retorná-lo
   * @return AdminService
   */
  private static function getService(): AdminService {
    return new AdminService();
  }

  /**
   * método responsável por renderizar a página de login
   * @param  Request $request
   * @return string
   */
  public static function getLogin($request): string {
    //renderiza o conteúdo da página de login
    $content = View::render('admin/user/login', []);
    //retorna a página renderizada
    return parent::getPage('Login', $content);
  }

  /**
   * método responsável por executar o login do admin
   * @param  Request $request
   * @return mixed
   */
  public static function setLogin($request): mixed {
      //pega as credenciais de usuário nas variáveis de post
      $vars  = $request->getPostVars();
      $email = $vars['email'] ?? '';
      $pass  = $vars['password'] ?? '';
      //busca usuário no banco através do email
      $admin = self::getService()->getAdmin($email);
      //verifica se as credenciais estão corretas
      if(!$admin instanceof Admin || !password_verify($pass,$admin->getPassword())) {
        return self::getLogin($request);
      }
      //loga o usuário
      Login::login($admin);
      //redireciona para a página de login após logar
      $request->getRouter()->redirect('/admin');
  }

  /**
   * método responsável por deslogar o admin
   * @param Request $request
   */
  public static function setLogout($request): void {
    //desloga o usuário
    Login::logout();
    //redireciona para a página de login
    $request->getRouter()->redirect('/admin/login');
  }
}
