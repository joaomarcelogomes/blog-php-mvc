<?php

namespace Source\Controller\Admin;

use \Source\UI\View;
use \Source\Service\AdminService;
use \Source\Utils\Session\Admin\Login;
use \Source\Model\Admin;

class LoginController extends PageController {

  /**
   * método responsável por instanciar o service e retorná-lo
   * @return AdminService
   */
  private static function getService(): AdminService {
    return new AdminService();
  }


  public static function getLogin($request): string {
    $content = View::render('admin/login', []);
    return parent::getPage('Login', $content);
  }

  public static function setLogin($request): Request {
      $vars  = $request->getPostVars();

      $email = $vars['email'] ?? '';
      $pass  = $vars['password'] ?? '';

      $admin = self::getService()->getAdmin($email);

      if(!$admin instanceof Admin || !password_verify($pass,$admin->getPassword())) {
        return self::getLogin($request);
      }

      Login::login($admin);

      $request->getRouter()->redirect('/admin');
  }
}
